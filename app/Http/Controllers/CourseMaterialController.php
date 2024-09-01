<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseMaterial;
use Illuminate\Support\Facades\Http;
use Smalot\PdfParser\Parser as PdfParser;
use PhpOffice\PhpWord\IOFactory;

class CourseMaterialController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_instructor_id' => 'required|exists:course_instructors,id',
            'file' => 'required|file|mimes:pdf,docx,pptx,zip|max:20480', 
        ]);

        $filePath = $request->file('file')->store('course_materials', 'public');
        $fileName = $request->file('file')->getClientOriginalName();

        $courseMaterial = CourseMaterial::create([
            'title' => $request->title,
            'description' => $request->description,
            'course_instructor_id' => $request->course_instructor_id,
            'file_path' => $filePath,
            'file_name' => $fileName,
        ]);

        return response()->json($courseMaterial, 201);
    }

    public function index($courseInstructorId)
    {
        $materials = CourseMaterial::where('course_instructor_id', $courseInstructorId)->get();
        return response()->json($materials);
    }
    
    public function show($id)
    {
        $material = CourseMaterial::findOrFail($id);
        return response()->json($material);
    }
    
    public function download($id)
    {
        $material = CourseMaterial::findOrFail($id);
        return response()->download(storage_path('app/public/' . $material->file_path), $material->file_name);
    }

    public function destroy($id)
    {
        $item = CourseMaterial::withTrashed()->findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $item = CourseMaterial::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = CourseMaterial::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }

    public function generate(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,docx,txt',
        ]);
    
        $file = $request->file('file');
        $fileContent = '';
    
        try {
            switch ($file->extension()) {
                case 'pdf':
                    try {
                        $pdfParser = new \Smalot\PdfParser\Parser();
                        $pdf = $pdfParser->parseFile($file->path());
                        $fileContent = $pdf->getText();
                    } catch (\Exception $e) {
                        \Log::error('PDF Parsing Error: ' . $file->path() . ' - ' . $e->getMessage());
                        return response()->json(['error' => 'Failed to extract content from PDF file'], 500);
                    }
                    break;
                
                    case 'docx':
                        try {
                            $phpWord = \PhpOffice\PhpWord\IOFactory::load($file->path());
                            foreach ($phpWord->getSections() as $section) {
                                foreach ($section->getElements() as $element) {
                                    if (method_exists($element, 'getText')) {
                                        $fileContent .= $element->getText();
                                    }
                                }
                            }
                        } catch (\Exception $e) {
                            \Log::error('DOCX Parsing Error: ' . $file->path() . ' - ' . $e->getMessage());
                            return response()->json(['error' => 'Failed to extract content from DOCX file'], 500);
                        }
                        break;
                    
                    try {
                        $phpWord = \PhpOffice\PhpWord\IOFactory::load($file->path());
                        foreach ($phpWord->getSections() as $section) {
                            $fileContent .= \PhpOffice\PhpWord\Shared\Html::addHtml($section);
                        }
                    } catch (\Exception $e) {
                        \Log::error('DOCX Parsing Error: ' . $file->path() . ' - ' . $e->getMessage());
                        return response()->json(['error' => 'Failed to extract content from DOCX file'], 500);
                    }
                    break;
                
                case 'txt':
                    try {
                        $fileContent = file_get_contents($file->path());
                    } catch (\Exception $e) {
                        \Log::error('TXT File Reading Error: ' . $file->path() . ' - ' . $e->getMessage());
                        return response()->json(['error' => 'Failed to read content from TXT file'], 500);
                    }
                    break;
            }
    
            \Log::info('Extracted File Content: ' . substr($fileContent, 0, 1000)); 
    
            if (empty($fileContent)) {
                return response()->json(['error' => 'Failed to extract content from the file'], 400);
            }
    
            $content = substr($fileContent, 0, 4000); 
            $response = $this->requestOpenAI($content);
    
            return response()->json($response);
    
        } catch (\Exception $e) {
            \Log::error('Error generating questions: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to process file'], 500);
        }
    }
    
    private function requestOpenAI($content)
    {
        $openaiApiKey = env('OPENAI_API_KEY');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $openaiApiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a helpful assistant.',
                ],
                [
                    'role' => 'user',
                    'content' => 'Generate practice questions for the following content, make sure to include some big problems also if the content allows for it:\n' . $content,
                ],
            ],
            'max_tokens' => 2000,
            'temperature' => 0.5,
        ]);
    
        $responseData = $response->json();
    
        if (isset($responseData['choices'][0]['message']['content'])) {
            return ['questions' => $responseData['choices'][0]['message']['content']];
        } else {
            \Log::error('Unexpected OpenAI API Response: ' . $response->body());
            return ['error' => 'Failed to generate questions'];
        }
    }
    
}
