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
use App\Http\Controllers\PaymentSettingController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FinancialAidScholarshipController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OpenAIChatController;
use App\Http\Controllers\SalaryPaymentController;
use App\Http\Controllers\CourseEvaluationController;

Route::post('openai-instructor', [AIInstructorInteractionController::class, 'chat']);

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::get('me', [AuthController::class, 'me'])->middleware('authenticate');
});

Route::apiResource('faculties', FacultyController::class)->only(['index', 'show']);

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('faculties', FacultyController::class)->only(['store', 'update', 'destroy']);
    Route::post('faculties/{id}/restore', [FacultyController::class, 'restore']);
    Route::delete('faculties/{id}/force-delete', [FacultyController::class, 'forceDelete']);
});

Route::apiResource('campuses', CampusController::class)->only(['index', 'show']);

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('campuses', CampusController::class)->only(['store', 'update', 'destroy']);
    Route::post('campuses/{id}/restore', [CampusController::class, 'restore']);
    Route::delete('campuses/{id}/force-delete', [CampusController::class, 'forceDelete']);
});

Route::apiResource('departments', DepartmentController::class)->only(['index', 'show']);

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('departments', DepartmentController::class)->only(['store', 'update', 'destroy']);
    Route::post('departments/{id}/restore', [DepartmentController::class, 'restore']);
    Route::delete('departments/{id}/force-delete', [DepartmentController::class, 'forceDelete']);
});

Route::apiResource('centers', CenterController::class)->only(['index', 'show']);

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('centers', CenterController::class)->only(['store', 'update', 'destroy']);
    Route::post('centers/{id}/restore', [CenterController::class, 'restore']);
    Route::delete('centers/{id}/force-delete', [CenterController::class, 'forceDelete']);
});

Route::apiResource('majors', MajorController::class)->only(['index', 'show']);
Route::post('/suggest-major', [MajorController::class, 'suggestMajor']);
Route::get('/majors/faculty/{facultyId}', [MajorController::class, 'getMajorsByFaculty']);

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('majors', MajorController::class)->only(['store', 'update', 'destroy']);
    Route::post('majors/{id}/restore', [MajorController::class, 'restore']);
    Route::delete('majors/{id}/force-delete', [MajorController::class, 'forceDelete']);
});

Route::apiResource('blocks', BlockController::class)->only(['index', 'show']);
Route::get('blocks-by-campus/{campus_id}', [BlockController::class, 'getBlocksByCampus']);

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('blocks', BlockController::class)->only(['store', 'update', 'destroy']);
    Route::post('blocks/{id}/restore', [BlockController::class, 'restore']);
    Route::delete('blocks/{id}/force-delete', [BlockController::class, 'forceDelete']);
});

Route::apiResource('rooms', RoomController::class)->only(['index', 'show']);
Route::get('rooms-by-block/{block_id}', [RoomController::class, 'getRoomsByBlock']);

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('rooms', RoomController::class)->only(['store', 'update', 'destroy']);
    Route::post('rooms/{id}/restore', [RoomController::class, 'restore']);
    Route::delete('rooms/{id}/force-delete', [RoomController::class, 'forceDelete']);
});

Route::apiResource('courses', CourseController::class)->only(['index', 'show']);
Route::get('/courses/faculty/{facultyId}', [CourseController::class, 'getCoursesByFaculty']);
Route::get('/courses/major/{majorId}', [CourseController::class, 'getCoursesByMajor']);

Route::middleware(['auth:api', 'role:Student'])->group(function () {
    Route::get('suggest-courses', [CourseController::class, 'suggestCoursesForNextSemester']);
    Route::get('available-courses/student', [CourseController::class, 'getAvailableCoursesForStudent']);
});

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('courses', CourseController::class)->only(['store', 'update', 'destroy']);
    Route::post('courses/{id}/restore', [CourseController::class, 'restore']);
    Route::delete('courses/{id}/force-delete', [CourseController::class, 'forceDelete']);
});

Route::apiResource('semesters', SemesterController::class)->only(['index', 'show']);
Route::get('/semester/current', [SemesterController::class, 'getCurrentSemester']);

Route::middleware(['auth:api', 'role:Student,Admin,Instructor'])->group(function () {
    Route::get('/semesters_by_student/{id}', [SemesterController::class, 'getSemestersForStudent']);
    Route::get('/semesters_by_instructor/{id}', [SemesterController::class, 'getSemestersForInstructor']);
});

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('semesters', SemesterController::class)->only(['store', 'update', 'destroy']);
    Route::post('semesters/{id}/restore', [SemesterController::class, 'restore']);
    Route::delete('semesters/{id}/force-delete', [SemesterController::class, 'forceDelete']);
});

Route::apiResource('users', UserController::class)->only(['index', 'show']);

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('users', UserController::class)->only(['store', 'update', 'destroy']);
    Route::post('users/{id}/restore', [UserController::class, 'restore']);
    Route::delete('users/{id}/force-delete', [UserController::class, 'forceDelete']);
});


Route::apiResource('students', StudentController::class)->only(['index', 'show']);

Route::middleware(['auth:api'])->group(function () {
    Route::get('/students/user/{userId}', [StudentController::class, 'getStudentByUserId']);
    Route::get('/students-with-users', [StudentController::class, 'getStudentsWithUserDetails']);
});

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('students', StudentController::class)->only(['store', 'update', 'destroy']);
    Route::post('students/{id}/restore', [StudentController::class, 'restore']);
    Route::delete('students/{id}/force-delete', [StudentController::class, 'forceDelete']);
});


Route::middleware(['auth:api', 'role:Admin'])->group(function () {

Route::apiResource('admins', AdminController::class);
Route::get('/admins/user/{userId}', [AdminController::class, 'getAdminByUserId']);
Route::post('admins/{id}/restore', [AdminController::class, 'restore']);
Route::delete('admins/{id}/force-delete', [AdminController::class, 'forceDelete']);
Route::get('/admins-with-users', [AdminController::class, 'getAdminsWithUserDetails']);
});

Route::apiResource('instructors', InstructorController::class)->only(['index', 'show']);

Route::middleware(['auth:api', 'role:Admin,Instructor,Student'])->group(function () {
    Route::get('/instructors/user/{userId}', [InstructorController::class, 'getInstructorByUserId']);
    Route::get('/instructors-with-users', [InstructorController::class, 'getInstructorsWithUserDetails']);
});

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('instructors', InstructorController::class)->only(['store', 'update', 'destroy']);
    Route::post('instructors/{id}/restore', [InstructorController::class, 'restore']);
    Route::delete('instructors/{id}/force-delete', [InstructorController::class, 'forceDelete']);
});

Route::apiResource('faculties-campuses', FacultyCampusController::class)->only(['index', 'show']);
Route::get('campuses/{campusId}/faculties', [FacultyCampusController::class, 'facultiesByCampus']);
Route::get('faculties/{facultyId}/campuses', [FacultyCampusController::class, 'campusesByFaculty']);
Route::get('faculty-campus-id/{facultyId}/{campusId}', [FacultyCampusController::class, 'getFacultyCampusId']);

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('faculties-campuses', FacultyCampusController::class)->only(['store', 'update', 'destroy']);
    Route::post('faculties-campuses/{id}/restore', [FacultyCampusController::class, 'restore']);
    Route::delete('faculties-campuses/{id}/force-delete', [FacultyCampusController::class, 'forceDelete']);
    Route::post('campuses/{campusId}/faculties/attach', [FacultyCampusController::class, 'attachFacultyToCampus']);
    Route::delete('campuses/{campusId}/faculties/{facultyId}', [FacultyCampusController::class, 'detachFacultyFromCampus']);
});

Route::apiResource('course-prerequisites', CoursePrerequisiteController::class)->only(['index', 'show']);
Route::get('courses/{course}/prerequisites', [CoursePrerequisiteController::class, 'getCoursePrerequisiteByCourse']);

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('course-prerequisites', CoursePrerequisiteController::class)->only(['store', 'update', 'destroy']);
    Route::post('course-prerequisites/{id}/restore', [CoursePrerequisiteController::class, 'restore']);
    Route::delete('course-prerequisites/{id}/force-delete', [CoursePrerequisiteController::class, 'forceDelete']);
});

Route::middleware('auth:api')->group(function () {
    Route::apiResource('course-instructors', CourseInstructorController::class)->only(['index', 'show']);
    Route::get('/course-details/{courseInstructorId}', [CourseInstructorController::class, 'getCourseDetails']);
    Route::get('/instructors/{id}/courses', [CourseInstructorController::class, 'getCoursesForInstructor']);
    Route::get('courses/{id}/options', [CourseInstructorController::class, 'getCourseOptions']);
    Route::get('courses/{id}/available-options', [CourseInstructorController::class, 'getAvailableCourseOptions']);
});

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('course-instructors', CourseInstructorController::class)->only(['store', 'update', 'destroy']);
    Route::get('instructor_name_by_course_instructor/{id}', [CourseInstructorController::class, 'getInstructorNameByCourseInstructorId']);
    Route::get('course_name_by_course_instructor/{id}', [CourseInstructorController::class, 'getCourseNameByCourseInstructorId']);
    Route::get('instructor_by_course/{id}', [CourseInstructorController::class, 'getInstructorDetails']);
    Route::post('course-instructors/{id}/restore', [CourseInstructorController::class, 'restore']);
    Route::delete('course-instructors/{id}/force-delete', [CourseInstructorController::class, 'forceDelete']);
});

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('dorms', DormController::class);
    Route::get('dorms/{dormId}/rooms', [DormRoomController::class, 'roomsByDorm']);
    Route::post('dorms/{id}/restore', [DormController::class, 'restore']);
    Route::delete('dorms/{id}/force-delete', [DormController::class, 'forceDelete']);

    Route::apiResource('dorm-rooms', DormRoomController::class);
    Route::post('dorm-rooms/{id}/restore', [DormRoomController::class, 'restore']);
    Route::delete('dorm-rooms/{id}/force-delete', [DormRoomController::class, 'forceDelete']);

    Route::apiResource('bus-routes', BusRouteController::class);
    Route::post('bus-routes/{id}/restore', [BusRouteController::class, 'restore']);
    Route::delete('bus-routes/{id}/force-delete', [BusRouteController::class, 'forceDelete']);
});

Route::middleware('auth:api')->group(function () {
    Route::apiResource('registrations', RegistrationController::class);
    Route::get('course-instructor-students/{id}', [RegistrationController::class, 'getRegisteredStudents']);
    Route::get('student/{id}/registration', [RegistrationController::class, 'getRegistrationsByStudent']);
});

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::post('registrations/{id}/restore', [RegistrationController::class, 'restore']);
    Route::delete('registrations/{id}/force-delete', [RegistrationController::class, 'forceDelete']);
});


Route::middleware('auth:api')->group(function () {
    Route::apiResource('exams', ExamController::class)->only(['index', 'show']);
    Route::get('exams/details/{id}', [ExamController::class, 'getExamsForStudent']);
    Route::get('exams/instructor-details/{id}', [ExamController::class, 'getExamsForInstructor']);
    Route::get('get_exam_details', [ExamController::class, 'getAllExams']);
});

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('exams', ExamController::class)->only(['store', 'update', 'destroy']);
    Route::post('exams/{id}/restore', [ExamController::class, 'restore']);
    Route::delete('exams/{id}/force-delete', [ExamController::class, 'forceDelete']);
});


Route::middleware('auth:api')->group(function () {
    Route::apiResource('grades', GradeController::class)->only(['index', 'show']);
    Route::get('/grades/get/{course_instructor_id}', [GradeController::class, 'getGradesByInstructor']);
});

Route::middleware(['auth:api', 'role:Instructor'])->group(function () {
    Route::apiResource('grades', GradeController::class)->only(['store', 'update', 'destroy']);
    Route::post('/grades/add', [GradeController::class, 'addGrade']);
});

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::post('grades/{id}/restore', [GradeController::class, 'restore']);
    Route::delete('grades/{id}/force-delete', [GradeController::class, 'forceDelete']);
});


Route::middleware('auth:api')->group(function () {
    Route::apiResource('assignments', AssignmentController::class)->only(['index', 'show']);
    Route::get('assignments/instructor/{courseInstructorId}', [AssignmentController::class, 'getByInstructor']);
});

Route::middleware(['auth:api', 'role:Instructor'])->group(function () {
    Route::apiResource('assignments', AssignmentController::class)->only(['store', 'update', 'destroy']);
});

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::post('assignments/{id}/restore', [AssignmentController::class, 'restore']);
    Route::delete('assignments/{id}/force-delete', [AssignmentController::class, 'forceDelete']);
});

Route::get('/submissions/{id}/download', [SubmissionController::class, 'download']);
Route::middleware('auth:api')->group(function () {
    Route::get('/assignments/{assignmentId}/submissions', [SubmissionController::class, 'index']);
    Route::post('/assignments/{assignmentId}/submissions', [SubmissionController::class, 'store']);
    Route::delete('/submissions/{id}', [SubmissionController::class, 'destroy']);
    Route::get('/assignments/{assignmentId}/all-submissions', [SubmissionController::class, 'getAllSubmissions']);
});

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::post('/submissions/{id}/restore', [SubmissionController::class, 'restore']);
    Route::delete('/submissions/{id}/force-delete', [SubmissionController::class, 'forceDelete']);
});

Route::apiResource('important_dates', ImportantDateController::class)->only(['show', 'index']);

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('important_dates', ImportantDateController::class)->only(['store', 'update', 'destroy']);
    Route::post('important_dates/{id}/restore', [ImportantDateController::class, 'restore']);
    Route::delete('important_dates/{id}/force-delete', [ImportantDateController::class, 'forceDelete']);
});

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('dorm_registrations', DormRegistrationController::class);
    Route::get('dorm_registrations_for_room/{id}', [DormRegistrationController::class, 'getRegistrationsByDormRoom']);
    Route::post('dorm_registrations/{id}/restore', [DormRegistrationController::class, 'restore']);
    Route::delete('dorm_registrations/{id}/force-delete', [DormRegistrationController::class, 'forceDelete']);
});

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('bus_registrations', BusRegistrationController::class);
    Route::get('bus_registrations_for_route/{id}', [BusRegistrationController::class, 'getRegistrationsForBusRoute']);
    Route::post('bus_registrations/{id}/restore', [BusRegistrationController::class, 'restore']);
    Route::delete('bus_registrations/{id}/force-delete', [BusRegistrationController::class, 'forceDelete']);
});

Route::apiResource('news', NewsController::class)->only(['show', 'index']);

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('news', NewsController::class)->only(['store', 'update', 'destroy']);
    Route::post('news/{id}/restore', [NewsController::class, 'restore']);
    Route::delete('news/{id}/force-delete', [NewsController::class, 'forceDelete']);
});

Route::apiResource('announcements', AnnouncementController::class)->only(['show', 'index']);

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('announcements', AnnouncementController::class)->only(['store', 'update', 'destroy']);
    Route::post('announcements/{id}/restore', [AnnouncementController::class, 'restore']);
    Route::delete('announcements/{id}/force-delete', [AnnouncementController::class, 'forceDelete']);
});

Route::get('deans/campus/{campusId}', [DeanController::class, 'getDeansByCampus']);
Route::get('/deans/{facultyId}/{campusId}', [DeanController::class, 'getDeanByFacultyAndCampus']);
Route::apiResource('deans', DeanController::class)->only(['show', 'index']);

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('deans', DeanController::class)->only(['store', 'update', 'destroy']);
    Route::post('deans/{id}/restore', [DeanController::class, 'restore']);
    Route::delete('deans/{id}/force-delete', [DeanController::class, 'forceDelete']);
});

Route::get('/course-materials/{id}/download', [CourseMaterialController::class, 'download']);

Route::middleware('auth:api')->group(function () {
    Route::get('/instructor-courses/{courseInstructorId}/materials', [CourseMaterialController::class, 'index']);
    Route::get('/course-materials/{id}', [CourseMaterialController::class, 'show']);
    Route::post('/generate-practice-questions', [CourseMaterialController::class, 'generate']);
});

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('salary-payments', SalaryPaymentController::class);
});

Route::middleware(['auth:api', 'role:Instructor'])->group(function () {
    Route::delete('/course-materials/{id}', [CourseMaterialController::class, 'destroy']);
    Route::post('/instructor-courses/{courseInstructorId}/materials', [CourseMaterialController::class, 'store']);
});

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::post('/course_materials/{id}/restore', [CourseMaterialController::class, 'restore']);
    Route::delete('/course_materials/{id}/force-delete', [CourseMaterialController::class, 'forceDelete']);
});

Route::apiResource('library_books', LibraryBookController::class)->only(['index', 'show']);

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('library_books', LibraryBookController::class)->only(['store', 'update', 'destroy']);
    Route::post('library_books/{id}/restore', [LibraryBookController::class, 'restore']);
    Route::delete('library_books/{id}/force-delete', [LibraryBookController::class, 'forceDelete']);
});


Route::middleware('auth:api')->group(function () {
    Route::apiResource('book_borrows', BookBorrowController::class);
    Route::post('/book-borrow', [BookBorrowController::class, 'borrowBook']);
    Route::get('book_borrows/by_book_and_user/{bookId}', [BookBorrowController::class, 'getBorrowRequestsForBookByLoggedInUser']);
    Route::get('book_borrows/by_book/{bookId}', [BookBorrowController::class, 'indexByBookId']);
});

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::post('book_borrows/{id}/restore', [BookBorrowController::class, 'restore']);
    Route::delete('book_borrows/{id}/force-delete', [BookBorrowController::class, 'forceDelete']);
});

Route::middleware('auth:api')->group(function () {
    Route::apiResource('course_drop_requests', CourseDropRequestController::class);
    Route::post('course_drop_requests/request', [CourseDropRequestController::class, 'requestDrop']);
    Route::get('/course_drop_requests/check_student_request/{courseInstructorId}', [CourseDropRequestController::class, 'checkDropRequestForStudent']);
    Route::get('course_drop_requests/instructor/{courseInstructorId}', [CourseDropRequestController::class, 'getDropRequestsByInstructor']);
});

Route::middleware(['auth:api', 'role:Instructor'])->group(function () {
    Route::put('course_drop_requests/{id}/status', [CourseDropRequestController::class, 'updateStatus']);
});

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::post('course_drop_requests/{id}/restore', [CourseDropRequestController::class, 'restore']);
    Route::delete('course_drop_requests/{id}/force-delete', [CourseDropRequestController::class, 'forceDelete']);
});


Route::middleware('auth:api')->group(function () {
    Route::delete('ai_instructor_interactions/clear', [AIInstructorInteractionController::class, 'clear']);
    Route::apiResource('ai_instructor_interactions', AIInstructorInteractionController::class);
});

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::post('ai_instructor_interactions/{id}/restore', [AIInstructorInteractionController::class, 'restore']);
    Route::delete('ai_instructor_interactions/{id}/force-delete', [AIInstructorInteractionController::class, 'forceDelete']);
});

Route::get('majors/{facultyId}/campuses/{campusId}', [MajorFacultyCampusController::class, 'getMajorsByFacultyAndCampus']);
Route::apiResource('majors_faculties_campuses', MajorFacultyCampusController::class)->only(['index', 'show']);

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::apiResource('majors_faculties_campuses', MajorFacultyCampusController::class)->only(['store', 'update', 'destroy']);
    Route::post('majors_faculties_campuses/{id}/restore', [MajorFacultyCampusController::class, 'restore']);
    Route::delete('majors_faculties_campuses/{id}/force-delete', [MajorFacultyCampusController::class, 'forceDelete']);
    Route::post('/attach-major', [MajorFacultyCampusController::class, 'attachMajorToFacultyCampus']);
    Route::post('/detach-major', [MajorFacultyCampusController::class, 'detachMajorFromFacultyCampus']);
});

Route::middleware('auth:api')->group(function () {
    Route::apiResource('payment-settings', PaymentSettingController::class)->only(['show', 'index']);
    Route::apiResource('fees', FeeController::class)->only(['show', 'index', 'store']);
    Route::apiResource('payments', PaymentController::class)->only(['show', 'index']);

    Route::get('fees_for_student/{id}', [FeeController::class, 'getFeesByStudent']);
    Route::get('total_fees_for_student/{id}', [FeeController::class, 'getTotalFeesByStudent']);
    Route::get('payments_for_student/{id}', [PaymentController::class, 'getPaymentsByStudent']);
    Route::get('check-fees', [PaymentController::class, 'checkFeesPaid']);
    
    Route::get('/financial-aid-scholarships/student/{studentId}', [FinancialAidScholarshipController::class, 'getFinancialAidsScholarshipsByStudent']);
});

Route::middleware(['auth:api', 'role:Admin'])->group(function () {

    Route::apiResource('payment-settings', PaymentSettingController::class)->only(['store', 'update', 'destroy']);
    Route::post('payment-settings/{id}/restore', [PaymentSettingController::class, 'restore']);
    Route::delete('payment-settings/{id}/force-delete', [PaymentSettingController::class, 'forceDelete']);
    
    Route::apiResource('fees', FeeController::class)->only(['update', 'destroy']);
    Route::post('fees/{id}/restore', [FeeController::class, 'restore']);
    Route::delete('fees/{id}/force-delete', [FeeController::class, 'forceDelete']);

    Route::apiResource('payments', PaymentController::class)->only(['store', 'update', 'destroy']);
    Route::post('payments/{id}/restore', [PaymentController::class, 'restore']);
    Route::delete('payments/{id}/force-delete', [PaymentController::class, 'forceDelete']);
    
    Route::post('/financial-aid-scholarships', [FinancialAidScholarshipController::class, 'createFinancialAidScholarship']);
    Route::delete('/financial-aid-scholarships/{id}', [FinancialAidScholarshipController::class, 'deleteFinancialAidScholarship']);
    Route::post('financial-aid-scholarships/{id}/restore', [FinancialAidScholarshipController::class, 'restore']);
    Route::delete('financial-aid-scholarships/{id}/force-delete', [FinancialAidScholarshipController::class, 'forceDelete']);
});

Route::middleware(['auth:api', 'role:Student'])->group(function () {
    Route::apiResource('course-evaluations', CourseEvaluationController::class);
});

Route::middleware(['auth:api', 'role:Admin'])->group(function () {
    Route::get('/course-evaluations/instructor/{courseInstructorId}', [CourseEvaluationController::class, 'getByInstructor']);
    Route::post('/course-analysis', [CourseEvaluationController::class, 'analyzeCourseInstructor']);
    Route::post('course-evaluations/{id}/restore', [CourseEvaluationController::class, 'restore']);
    Route::delete('course-evaluations/{id}/force-delete', [CourseEvaluationController::class, 'forceDelete']);
});
