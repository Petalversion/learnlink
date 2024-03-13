<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ckeditorController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InstructorWalletController;
use App\Http\Controllers\CommentsandReviewsController;
use App\Http\Controllers\CertificateController;
use App\Models\Instructor;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//Public
Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/about-us', [IndexController::class, 'showAboutUsPage'])->name('about.us');
Route::get('/become-an-instructor', [IndexController::class, 'showInstructorPage'])->name('become.instructor');
Route::get('/contact-us', [IndexController::class, 'showContactUsPage'])->name('contact.us');
Route::post('/contact-us', [IndexController::class, 'sendContactUsPage'])->name('contact.send');
Route::get('/course/{course_id}/details', [CourseController::class, 'details'])->name('course_details');
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
Route::get('/terms-and-condition', [IndexController::class, 'showTCPage'])->name('terms.condition');
Route::get('/instructor-info/{id}', [IndexController::class, 'showInstructorInfoPage'])->name('instructor.index');



// Admin Login
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);

// Instructor Registration
Route::get('/instructor/register', [InstructorController::class, 'showRegistrationForm'])->name('instructor.register');
Route::post('/instructor/register', [InstructorController::class, 'register']);
Route::post('/instructor/register', [InstructorController::class, 'store']);

// Instructor Login
Route::get('/instructor/login', [InstructorController::class, 'showLoginForm'])->name('instructor.login');
Route::post('/instructor/login', [InstructorController::class, 'login']);

// Student Registration
Route::get('/student/register', [StudentController::class, 'showRegistrationForm'])->name('student.register');
Route::post('/student/register', [StudentController::class, 'register']);
Route::post('/student/register', [StudentController::class, 'store']);

//Student Login
Route::get('/login', [StudentController::class, 'showLoginForm'])->name('student.login');
Route::post('/login', [StudentController::class, 'login'])->name('student.login');

//Search
Route::get('/search', [IndexController::class, 'search'])->name('search');

Route::middleware('auth:admin')->group(function () {
    // Admin Pages
    Route::get('/admin/dashboard', [AdminController::class, 'showAdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/users/instructor', [AdminController::class, 'showInstructorList'])->name('admin.instructor');
    Route::get('/admin/users/instructor/course/{instructor_id}', [AdminController::class, 'showCourseList'])->name('admin.course');
    Route::get('/admin/users/instructor/lesson/{course_id}', [AdminController::class, 'showCourseLesson'])->name('admin.lesson');
    Route::get('/admin/users/admin', [AdminController::class, 'showAdminList'])->name('admin.admin');
    Route::get('/admin/users/student', [AdminController::class, 'showStudentList'])->name('admin.student');
    Route::get('/admin/transactions', [AdminController::class, 'showTransactionList'])->name('admin.transaction');
    Route::get('/admin/withdrawal/requests', [AdminController::class, 'showWithdrawalRequestList'])->name('admin.withdrawal.request');
    Route::put('/admin/withdrawal/update', [AdminController::class, 'updateWithdrawalRequest'])->name('admin.withdrawal.update');
    Route::get('/admin/user', [AdminController::class, 'showUserProfile'])->name('admin.user');
    Route::get('/admin/user/table', [AdminController::class, 'getUserProfile'])->name('get.user');
    Route::put('/admin/users/instructor/update', [AdminController::class, 'updateStatus'])->name('update-status');
    Route::get('/admin/users/new-admin', [AdminController::class, 'showRegistrationForm'])->name('admin.register');
    Route::post('/admin/users/new-admin', [AdminController::class, 'register']);
    Route::post('/admin/users/new-admin', [AdminController::class, 'store']);
    Route::get('/admin/toc', [AdminController::class, 'toc'])->name('toc');
    Route::put('/admin/toc/update', [AdminController::class, 'tocUpdate'])->name('toc.update');
});

Route::middleware('auth:instructor')->group(function () {
    // Instructor Pages
    Route::get('dashboard', [InstructorController::class, 'showInstructorDashboard'])->name('instructor.dashboard');
    Route::get('course', [CourseController::class, 'index'])->name('instructor.course.course');
    Route::get('course/create', [CourseController::class, 'createCourse'])->name('instructor.course.course-create');
    Route::post('course/store', [CourseController::class, 'storeCourse'])->name('instructor.course.store');
    Route::get('course/{course_id}', [CourseController::class, 'courseView'])->name('instructor.course.course-view');
    Route::get('course/{course_id}/edit', [CourseController::class, 'courseEdit'])->name('instructor.course.course-edit');
    Route::put('course/{course_id}', [CourseController::class, 'update'])->name('instructor.course.update');
    Route::put('course/{course_id}/status', [CourseController::class, 'updateStatus'])->name('course.status.update');
    Route::delete('course/{course}', [CourseController::class, 'destroy'])->name('course.destroy');
    Route::get('instructor/tags', [TagController::class, 'show'])->name('instructor.course.tags');
    Route::get('instructor/tags/create', [TagController::class, 'create'])->name('instructor.course.tags-create');
    Route::post('instructor/tags/create', [TagController::class, 'store'])->name('instructor.course.tags.store');
    Route::get('instructor/categories/create', [CategoryController::class, 'create'])->name('instructor.course.category-create');
    Route::post('instructor/categories/create', [CategoryController::class, 'store'])->name('instructor.course.category.store');
    Route::get('instructor/show-category', [CategoryController::class, 'showCategory'])->name('instructor.course.category');
    Route::get('course/{course_id}/new-lesson', [LessonController::class, 'create'])->name('instructor.lesson.lesson-create');
    Route::post('lesson/store', [LessonController::class, 'store'])->name('instructor.lesson.lesson-store');
    Route::post('lesson/upload-image', [LessonController::class, 'uploadImage'])->name('instructor.lesson.upload-image');
    Route::delete('lesson/{lesson_id}/destroy', [LessonController::class, 'destroy'])->name('instructor.lesson.lesson-destroy');
    Route::get('course/lesson/{lesson_id}', [LessonController::class, 'lessonEdit'])->name('instructor.lesson.lesson-edit');
    Route::put('instructor/lesson/{lesson_id}', [LessonController::class, 'update'])->name('instructor.lesson.update');
    Route::get('course/{course_id}/new-question', [QuizController::class, 'create'])->name('instructor.exam.question-create');
    Route::post('instructor/quiz/store', [QuizController::class, 'store'])->name('instructor.exam.question-store');
    Route::delete('/instructor/quiz/{exam_id}/destroy', [QuizController::class, 'destroy'])->name('instructor.exam.question-destroy');
    Route::get('course/question/{exam_id}', [QuizController::class, 'examEdit'])->name('instructor.exam.question-edit');
    Route::put('instructor/quiz/{exam_id}', [QuizController::class, 'update'])->name('instructor.exam.update');
    Route::post('instructor/ckeditor/upload', [ckeditorController::class, 'upload'])->name('ckeditor.upload');
    Route::get('instructor/recent-questions', [CommentsandReviewsController::class, 'instructorRecentComments'])->name('instructor.questions');
    Route::get('instructor/course/questions/{lesson_id}', [CommentsandReviewsController::class, 'instructorComments'])->name('instructor.course.questions');
    Route::get('instructor/reviews', [CommentsandReviewsController::class, 'reviews'])->name('instructor.reviews');
    Route::post('/instructor/add-answer/', [CommentsandReviewsController::class, 'storeAnswer'])->name('add.answer');
    Route::get('/instructor/profile', [InstructorController::class, 'profile'])->name('instructor.profile');
    Route::put('/instructor/profile/update', [InstructorController::class, 'profileUpdate'])->name('instructor.profileupdate');
    Route::get('/instructor/withdrawal-history', [InstructorWalletController::class, 'showTransactions'])->name('instructor.transactions');
    Route::get('/instructor/withdrawal-request', [InstructorWalletController::class, 'newTransactions'])->name('instructor.transactions.new');
    Route::post('/instructor/transactions/add', [InstructorWalletController::class, 'addTransactions'])->name('instructor.transactions.add');
});

Route::middleware('auth:student')->group(function () {
    //Student Pages
    // Route::get('/student/dashboard', [StudentController::class, 'showStudentDashboard'])->name('student.dashboard');
    Route::get('certificate/{course_id}', [CertificateController::class, 'certificate'])->name('certificate');
    Route::get('/student/courses', [StudentController::class, 'showStudentCourses'])->name('student.courses');
    Route::get('/student/certificates', [StudentController::class, 'showCertificates'])->name('student.certificates');
    Route::get('/student/learn/{course_id}/lesson/{lesson_id}', [StudentController::class, 'showLearn'])->name('student.learn');
    Route::get('/student/examination/{course_id}', [StudentController::class, 'exam'])->name('student.examination');
    Route::post('/save-score', [CertificateController::class, 'examAttempt'])->name('save.score');
    Route::get('/student/cart', [CartController::class, 'showCart'])->name('student.cart');
    Route::post('/student/add-to-cart/', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/student/cart/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
    Route::get('/student/pay', [PaymentController::class, 'pay'])->name('gcash.pay');
    Route::post('/student/PayPal', [PaypalController::class, 'pay'])->name('paypal.pay');
    Route::get('/student/pay/success/{transaction_id}', [PaymentController::class, 'success'])->name('gcash.success');
    Route::get('success', [PaypalController::class, 'success']);
    Route::get('error', [PaypalController::class, 'error']);
    Route::get('/student/profile', [StudentController::class, 'profile'])->name('student.profile');
    Route::put('/student/profile/update', [StudentController::class, 'profileUpdate'])->name('student.profileupdate');
    Route::post('/student/add-question/', [CommentsandReviewsController::class, 'storeQuestion'])->name('add.question');
    Route::post('/student/add-review/', [CommentsandReviewsController::class, 'storeReview'])->name('add.review');
    Route::get('/student/free/success/{course_id}', [StudentController::class, 'success'])->name('free.success');
    Route::get('/student/purchase-history', [StudentController::class, 'history'])->name('student.history');
});
