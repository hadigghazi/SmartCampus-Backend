<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Mail\AnnouncementMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Http\Requests\StoreAnnouncement;
use App\Http\Requests\UpdateAnnouncement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $items = Announcement::get();
        return response()->json($items);
    }

    public function store(StoreAnnouncement $request)
    {
        $item = Announcement::create($request->validated());
    
        $visibility = $item->visibility;
    
        $users = $this->getUsersBasedOnVisibility($visibility);
    
        foreach ($users as $user) {
            Mail::to($user->email)->send(new AnnouncementMail($item));
        }
    
        return response()->json($item, 201);
    }
    
    private function getUsersBasedOnVisibility($visibility)
    {
        switch ($visibility) {
            case 'Students':
                return User::where('role', 'Student')->get();
            case 'Instructors':
                return User::where('role', 'Instructor')->get();
            case 'Admins':
                return User::where('role', 'Admin')->get();
            case 'General':
                return User::all(); 
            default:
                return collect(); 
        }
    }
    

    public function show($id)
    {
        $item = Announcement::withTrashed()->findOrFail($id);
        if ($item->trashed()) {
            return response()->json(['error' => 'Not found'], 404);
        }
        return response()->json($item);
    }

    public function update(UpdateAnnouncement $request, $id)
    {
        $item = Announcement::withTrashed()->findOrFail($id);
        $item->update($request->validated());
        $visibility = $item->visibility;
    
        $users = $this->getUsersBasedOnVisibility($visibility);
    
        foreach ($users as $user) {
            Mail::to($user->email)->send(new AnnouncementMail($item));
        }
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = Announcement::withTrashed()->findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $item = Announcement::withTrashed()->findOrFail($id);
        $item->restore();
        return response()->json($item);
    }

    public function forceDelete($id)
    {
        $item = Announcement::withTrashed()->findOrFail($id);
        $item->forceDelete();
        return response()->json(null, 204);
    }
}
