<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\FacultyCampusController;
use App\Http\Controllers\CoursePrerequisiteController;
use App\Http\Controllers\CourseInstructorController;
use App\Http\Controllers\DormController;
use App\Http\Controllers\DormRoomController;
use App\Http\Controllers\BusRouteController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\FinancialAidScholarshipController;
use App\Http\Controllers\ImportantDateController;
use App\Http\Controllers\DormRegistrationController;
use App\Http\Controllers\BusRegistrationController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\DeanController;
use App\Http\Controllers\CourseMaterialController;
use App\Http\Controllers\LibraryBookController;
use App\Http\Controllers\BookBorrowController;
use App\Http\Controllers\CourseDropRequestController;
use App\Http\Controllers\AIInstructorInteractionController;
use App\Http\Controllers\MajorFacultyCampusController;
use App\Http\Controllers\AuthController;


Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::get('me', [AuthController::class, 'me'])->middleware('auth:api');
});

// Route::group([
//     'middleware' => 'auth.user',
//     'prefix' => 'faculties'
// ], function () {
//     Route::apiResource('/', FacultyController::class);

//     Route::post('faculties/{id}/restore', [FacultyController::class, 'restore']);
//     Route::delete('faculties/{id}/force-delete', [FacultyController::class, 'forceDelete']);
// });

Route::apiResource('faculties', FacultyController::class);
Route::post('faculties/{id}/restore', [FacultyController::class, 'restore']);
Route::delete('faculties/{id}/force-delete', [FacultyController::class, 'forceDelete']);

Route::apiResource('campuses', CampusController::class);
Route::post('campuses/{id}/restore', [CampusController::class, 'restore']);
Route::delete('campuses/{id}/force-delete', [CampusController::class, 'forceDelete']);

Route::apiResource('departments', DepartmentController::class);
Route::post('departments/{id}/restore', [DepartmentController::class, 'restore']);
Route::delete('departments/{id}/force-delete', [DepartmentController::class, 'forceDelete']);

Route::apiResource('centers', CenterController::class);
Route::post('centers/{id}/restore', [CenterController::class, 'restore']);
Route::delete('centers/{id}/force-delete', [CenterController::class, 'forceDelete']);

Route::apiResource('majors', MajorController::class);
Route::post('/suggest-major', [MajorController::class, 'suggestMajor']);
Route::get('/majors/faculty/{facultyId}', [MajorController::class, 'getMajorsByFaculty']);
Route::post('majors/{id}/restore', [MajorController::class, 'restore']);
Route::delete('majors/{id}/force-delete', [MajorController::class, 'forceDelete']);

Route::apiResource('blocks', BlockController::class);
Route::get('blocks-by-campus/{campus_id}', [BlockController::class, 'getBlocksByCampus']);
Route::post('blocks/{id}/restore', [BlockController::class, 'restore']);
Route::delete('blocks/{id}/force-delete', [BlockController::class, 'forceDelete']);

Route::apiResource('rooms', RoomController::class);
Route::get('rooms-by-block/{block_id}', [RoomController::class, 'getRoomsByBlock']);
Route::post('rooms/{id}/restore', [RoomController::class, 'restore']);
Route::delete('rooms/{id}/force-delete', [RoomController::class, 'forceDelete']);

Route::apiResource('courses', CourseController::class);
Route::post('courses/{id}/restore', [CourseController::class, 'restore']);
Route::delete('courses/{id}/force-delete', [CourseController::class, 'forceDelete']);
Route::get('/courses/faculty/{facultyId}', [CourseController::class, 'getCoursesByFaculty']);
Route::get('/courses/major/{majorId}', [CourseController::class, 'getCoursesByMajor']);

Route::apiResource('semesters', SemesterController::class);
Route::post('semesters/{id}/restore', [SemesterController::class, 'restore']);
Route::delete('semesters/{id}/force-delete', [SemesterController::class, 'forceDelete']);

Route::apiResource('users', UserController::class);
Route::post('users/{id}/restore', [UserController::class, 'restore']);
Route::delete('users/{id}/force-delete', [UserController::class, 'forceDelete']);

Route::apiResource('students', StudentController::class)->except(['create', 'edit']);
Route::get('/students/user/{userId}', [StudentController::class, 'getStudentByUserId']);
Route::post('students/{id}/restore', [StudentController::class, 'restore']);
Route::delete('students/{id}/force-delete', [StudentController::class, 'forceDelete']);
Route::get('/students-with-users', [StudentController::class, 'getStudentsWithUserDetails']);

Route::apiResource('contacts', ContactController::class)->except(['create', 'edit']);
Route::post('contacts/{id}/restore', [ContactController::class, 'restore']);
Route::delete('contacts/{id}/force-delete', [ContactController::class, 'forceDelete']);

Route::apiResource('admins', AdminController::class);
Route::get('/admins/user/{userId}', [AdminController::class, 'getAdminByUserId']);
Route::post('admins/{id}/restore', [AdminController::class, 'restore']);
Route::delete('admins/{id}/force-delete', [AdminController::class, 'forceDelete']);
Route::get('/admins-with-users', [AdminController::class, 'getAdminsWithUserDetails']);

Route::apiResource('instructors', InstructorController::class);
Route::get('/instructors/user/{userId}', [InstructorController::class, 'getInstructorByUserId']);
Route::post('instructors/{id}/restore', [InstructorController::class, 'restore']);
Route::delete('instructors/{id}/force-delete', [InstructorController::class, 'forceDelete']);
Route::get('/instructors-with-users', [InstructorController::class, 'getInstructorsWithUserDetails']);

Route::apiResource('addresses', AddressController::class);
Route::post('addresses/{id}/restore', [AddressController::class, 'restore']);
Route::delete('addresses/{id}/force-delete', [AddressController::class, 'forceDelete']);

Route::apiResource('faculties-campuses', FacultyCampusController::class);
Route::get('campuses/{campusId}/faculties', [FacultyCampusController::class, 'facultiesByCampus']);
Route::get('faculties/{facultyId}/campuses', [FacultyCampusController::class, 'campusesByFaculty']);
Route::post('faculties-campuses/{id}/restore', [FacultyCampusController::class, 'restore']);
Route::delete('faculties-campuses/{id}/force-delete', [FacultyCampusController::class, 'forceDelete']);
Route::post('campuses/{campusId}/faculties/attach', [FacultyCampusController::class, 'attachFacultyToCampus']);
Route::delete('campuses/{campusId}/faculties/{facultyId}', [FacultyCampusController::class, 'detachFacultyFromCampus']);

Route::apiResource('course-prerequisites', CoursePrerequisiteController::class);
Route::get('courses/{course}/prerequisites', [CoursePrerequisiteController::class, 'getCoursePrerequisiteByCourse']);
Route::post('course-prerequisites/{id}/restore', [CoursePrerequisiteController::class, 'restore']);
Route::delete('course-prerequisites/{id}/force-delete', [CoursePrerequisiteController::class, 'forceDelete']);

Route::apiResource('course-instructors', CourseInstructorController::class);
Route::get('courses/{id}/options', [CourseInstructorController::class, 'getCourseOptions']);
Route::post('course-instructors/{id}/restore', [CourseInstructorController::class, 'restore']);
Route::delete('course-instructors/{id}/force-delete', [CourseInstructorController::class, 'forceDelete']);

Route::apiResource('dorms', DormController::class);
Route::post('dorms/{id}/restore', [DormController::class, 'restore']);
Route::delete('dorms/{id}/force-delete', [DormController::class, 'forceDelete']);

Route::apiResource('dorm-rooms', DormRoomController::class);
Route::get('dorms/{dormId}/rooms', [DormRoomController::class, 'roomsByDorm']);
Route::post('dorm-rooms/{id}/restore', [DormRoomController::class, 'restore']);
Route::delete('dorm-rooms/{id}/force-delete', [DormRoomController::class, 'forceDelete']);

Route::apiResource('bus-routes', BusRouteController::class);
Route::post('bus-routes/{id}/restore', [BusRouteController::class, 'restore']);
Route::delete('bus-routes/{id}/force-delete', [BusRouteController::class, 'forceDelete']);
Route::get('campuses/{campusId}/bus-routes', [BusRouteController::class, 'routesByCampus']); 

Route::apiResource('registrations', RegistrationController::class);
Route::post('registrations/{id}/restore', [RegistrationController::class, 'restore']);
Route::delete('registrations/{id}/force-delete', [RegistrationController::class, 'forceDelete']);

Route::apiResource('exams', ExamController::class);
Route::get('get_exam_details', [ExamController::class, 'getAllExams']);
Route::get('exams/details/{id}', [ExamController::class, 'getExamDetails']);
Route::post('exams/{id}/restore', [ExamController::class, 'restore']);
Route::delete('exams/{id}/force-delete', [ExamController::class, 'forceDelete']);

Route::apiResource('grades', GradeController::class);
Route::post('grades/{id}/restore', [GradeController::class, 'restore']);
Route::delete('grades/{id}/force-delete', [GradeController::class, 'forceDelete']);

Route::apiResource('assignments', AssignmentController::class);
Route::post('assignments/{id}/restore', [AssignmentController::class, 'restore']);
Route::delete('assignments/{id}/force-delete', [AssignmentController::class, 'forceDelete']);

Route::apiResource('submissions', SubmissionController::class);
Route::post('submissions/{id}/restore', [SubmissionController::class, 'restore']);
Route::delete('submissions/{id}/force-delete', [SubmissionController::class, 'forceDelete']);

Route::apiResource('payments', PaymentController::class);
Route::post('payments/{id}/restore', [PaymentController::class, 'restore']);
Route::delete('payments/{id}/force-delete', [PaymentController::class, 'forceDelete']);

Route::apiResource('fees', FeeController::class);
Route::post('fees/{id}/restore', [FeeController::class, 'restore']);
Route::delete('fees/{id}/force-delete', [FeeController::class, 'forceDelete']);

Route::apiResource('financial_aid_scholarships', FinancialAidScholarshipController::class);
Route::post('financial_aid_scholarships/{id}/restore', [FinancialAidScholarshipController::class, 'restore']);
Route::delete('financial_aid_scholarships/{id}/force-delete', [FinancialAidScholarshipController::class, 'forceDelete']);

Route::apiResource('important_dates', ImportantDateController::class);
Route::post('important_dates/{id}/restore', [ImportantDateController::class, 'restore']);
Route::delete('important_dates/{id}/force-delete', [ImportantDateController::class, 'forceDelete']);

Route::apiResource('dorm_registrations', DormRegistrationController::class);
Route::post('dorm_registrations/{id}/restore', [DormRegistrationController::class, 'restore']);
Route::delete('dorm_registrations/{id}/force-delete', [DormRegistrationController::class, 'forceDelete']);

Route::apiResource('bus_registrations', BusRegistrationController::class);
Route::post('bus_registrations/{id}/restore', [BusRegistrationController::class, 'restore']);
Route::delete('bus_registrations/{id}/force-delete', [BusRegistrationController::class, 'forceDelete']);

Route::apiResource('news', NewsController::class);
Route::post('news/{id}/restore', [NewsController::class, 'restore']);
Route::delete('news/{id}/force-delete', [NewsController::class, 'forceDelete']);

Route::apiResource('announcements', AnnouncementController::class);
Route::post('announcements/{id}/restore', [AnnouncementController::class, 'restore']);
Route::delete('announcements/{id}/force-delete', [AnnouncementController::class, 'forceDelete']);

Route::apiResource('deans', DeanController::class);
Route::post('deans/{id}/restore', [DeanController::class, 'restore']);
Route::delete('deans/{id}/force-delete', [DeanController::class, 'forceDelete']);
Route::get('deans/campus/{campusId}', [DeanController::class, 'getDeansByCampus']);

Route::apiResource('course_materials', CourseMaterialController::class);
Route::post('course_materials/{id}/restore', [CourseMaterialController::class, 'restore']);
Route::delete('course_materials/{id}/force-delete', [CourseMaterialController::class, 'forceDelete']);

Route::apiResource('library_books', LibraryBookController::class);
Route::post('library_books/{id}/restore', [LibraryBookController::class, 'restore']);
Route::delete('library_books/{id}/force-delete', [LibraryBookController::class, 'forceDelete']);

Route::apiResource('book_borrows', BookBorrowController::class);
Route::post('book_borrows/{id}/restore', [BookBorrowController::class, 'restore']);
Route::delete('book_borrows/{id}/force-delete', [BookBorrowController::class, 'forceDelete']);
Route::get('book_borrows/by_book/{bookId}', [BookBorrowController::class, 'indexByBookId']);

Route::apiResource('course_drop_requests', CourseDropRequestController::class);
Route::post('course_drop_requests/{id}/restore', [CourseDropRequestController::class, 'restore']);
Route::delete('course_drop_requests/{id}/force-delete', [CourseDropRequestController::class, 'forceDelete']);

Route::group([
    'middleware' => 'authenticate',
    'prefix' => 'ai_instructor_interactions'
], function () {
    Route::apiResource('/', AIInstructorInteractionController::class);

    Route::post('ai_instructor_interactions/{id}/restore', [AIInstructorInteractionController::class, 'restore']);
    Route::delete('ai_instructor_interactions/{id}/force-delete', [AIInstructorInteractionController::class, 'forceDelete']);
    Route::delete('ai_instructor_interactions/clear', [AIInstructorInteractionController::class, 'clear']);
});

Route::apiResource('majors_faculties_campuses', MajorFacultyCampusController::class);
Route::get('majors/{facultyId}/campuses/{campusId}', [MajorFacultyCampusController::class, 'getMajorsByFacultyAndCampus']);
Route::post('majors_faculties_campuses/{id}/restore', [MajorFacultyCampusController::class, 'restore']);
Route::delete('majors_faculties_campuses/{id}/force-delete', [MajorFacultyCampusController::class, 'forceDelete']);
