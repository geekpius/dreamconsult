<?php

/*
|--------------------------------------------------------------------------
| Administrators routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin'], function () {
    /*------- Auth------- */
    Route::get('/signin', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login');
    Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

    /*------- Password reset------- */
    Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset');

    /*------- Dashboard ------- */
    Route::get('/dashboard', 'AdminController@index')->name('admin.dashboard');
    Route::get('/change-password', 'AdminController@changePassword')->name('admin.changepwd');
    Route::post('/change-password', 'AdminController@updatePassword')->name('admin.changepwd.submit');   
        
    Route::get('/get-notification', 'AdminController@notification')->name('admin.notification');
    Route::get('/get-notitop', 'AdminController@notiTop')->name('admin.notitop');
    Route::post('/discount/approve', 'AdminController@approveDiscount')->name('admin.discount.approve');
    Route::post('/discount/reject', 'AdminController@rejectDiscount')->name('admin.discount.reject');
});


Route::group(['middleware' => ['auth:admin', 'admin']], function() {
    Route::group(['prefix' => 'admin'], function () {
        /*------- Users ------- */
        Route::get('/users', 'AdminController@users')->name('admin.users');
        Route::post('/users', 'AdminController@submitUsers')->name('admin.users.submit');
        Route::post('/users/edit', 'AdminController@edit')->name('admin.users.update');
        Route::get('/block/{admin}', 'AdminController@blockUnblock')->name('admin.block');
        Route::get('/delete/{admin}', 'AdminController@destroy')->name('admin.delete');
        Route::post('/branch-staff/transfer', 'AdminController@transferStaff')->name('admin.staff.transfer');
    
        /*------- Employees ------- */
        /* Route::get('/employees', 'EmployeeController@index')->name('admin.employees');
        Route::get('/job-positions', 'EmployeeController@jobPosition')->name('admin.employees.position');
        Route::post('/job-positions', 'EmployeeController@submitPosition')->name('admin.employees.position.submit');
        Route::post('/job-positions/edit', 'EmployeeController@updatePosition')->name('admin.employees.position.update');
        Route::get('/job-positions/{position}/delete', 'EmployeeController@deletePosition')->name('admin.employees.position.delete');

        Route::get('/taxes', 'EmployeeController@tax')->name('admin.employees.taxes');
        Route::post('/taxes', 'EmployeeController@submitTax')->name('admin.employees.taxes.submit');
        
        Route::get('/salary-structure', 'EmployeeController@salaryStructure')->name('admin.employees.structure');
        Route::get('/deductions', 'EmployeeController@deduction')->name('admin.employees.deduction'); */

        Route::get('/logs', 'LogController@index')->name('admin.logs');        
    });
});


Route::group(['middleware' => ['auth:admin', 'opera']], function() {
    Route::group(['prefix' => 'admin'], function () {
        /*------- Branches ------- */
        Route::get('/branches', 'BranchController@index')->name('admin.branch');
        Route::post('/branches', 'BranchController@store')->name('admin.branch.submit');
        Route::get('/branches/{branch}', 'BranchController@destroy')->name('admin.branch.delete');
    
        /*------- Courses ------- */
        Route::get('/services', 'CourseController@index')->name('admin.course');
        Route::post('/services', 'CourseController@store')->name('admin.course.submit');
        Route::get('/services/{course}', 'CourseController@destroy')->name('admin.course.delete');
        Route::post('/services/edit', 'CourseController@update')->name('admin.course.edit');
    
        /*------- Price ------- */
        Route::get('/prices', 'PriceController@index')->name('admin.price');
        Route::post('/prices', 'PriceController@store')->name('admin.price.submit');
        Route::post('/prices/edit', 'PriceController@edit')->name('admin.price.update');
        Route::get('/prices/{price}', 'PriceController@destroy')->name('admin.price.delete');

        /*------- Discount ------- */
        Route::get('/discount-giveout', 'DiscountController@index')->name('admin.discount');
        Route::post('/discount-giveout/checkid', 'DiscountController@checkID')->name('admin.discount.checkid');
        Route::post('/discount-giveout', 'DiscountController@store')->name('admin.discount.submit');
    });
});


Route::group(['middleware' => ['auth:admin', 'front']], function() {
    Route::group(['prefix' => 'admin'], function () {
        /*------- Visitors ------- */
        /* Route::get('/old-visitors', 'AdminStudentController@newVisitor')->name('admin.visitor');
        Route::post('/visitors', 'AdminStudentController@storeVisitor')->name('admin.visitor.submit');
        Route::post('/visitors/edit', 'AdminStudentController@updateVisitor')->name('admin.visitor.update'); */
        Route::get('/view-visitors', 'AdminStudentController@visitor')->name('admin.visitor.viewvisitor');
        Route::get('/view-visitors/{visitor}/delete', 'AdminStudentController@destroyVisitor')->name('admin.visitor.delete');
    
        /*------- Students ------- */
        Route::get('/register-clients', 'AdminStudentController@createstudent')->name('admin.student');
        Route::post('/register-clients', 'AdminStudentController@storeStudent')->name('admin.student.submit');
        Route::get('/view-registered-clients', 'AdminStudentController@student')->name('admin.viewstudent');
        Route::get('/view-registered-clients/{user}/info', 'AdminStudentController@studentInfo')->name('admin.student.info');
        Route::post('/view-registered-clients/service', 'AdminStudentController@addService')->name('admin.student.addservice.submit');
        Route::get('/view-registered-clients/{user}/edit', 'AdminStudentController@editStudent')->name('admin.student.edit');
        Route::post('/view-registered-clients', 'AdminStudentController@updateStudent')->name('admin.student.update');
        Route::post('/view-registered-clients/transfer', 'AdminStudentController@transferStudent')->name('admin.student.transfer');
        Route::get('/view-registered-clients/{user}/delete', 'AdminStudentController@destroyStudent')->name('admin.student.delete');

        Route::get('/registration/{user}/check', 'AdminStudentController@checkRegistration')->name('admin.viewstudent.checkreg');
        Route::get('/visitors', 'AdminStudentController@incompleteStudent')->name('admin.viewstudent.incomplete');
        Route::post('/visitors/{user}/update', 'AdminStudentController@updateComment')->name('admin.visitor.comment.update');
            
        /*------- Services ------- */
        Route::get('/registered-clients/{user}/services', 'AdminStudentController@createService')->name('admin.student.service');
    });
});

Route::group(['middleware' => ['auth:admin', 'account']], function() {
    Route::group(['prefix' => 'admin'], function () {
        /*------- Reports ------- */
        Route::get('/transactions-report', 'ReportController@transaction')->name('admin.transactions');
        Route::get('/transactions-report/all', 'ReportController@allTransaction')->name('admin.transactions.all');
        Route::get('/transactions-report/today', 'ReportController@todayTransaction')->name('admin.transactions.today');
        Route::get('/transactions-report/week', 'ReportController@weekTransaction')->name('admin.transactions.week');
        Route::get('/transactions-report/month', 'ReportController@monthTransaction')->name('admin.transactions.month');
        Route::get('/transactions-report/year', 'ReportController@yearTransaction')->name('admin.transactions.year');
        Route::post('/transactions-report/single', 'ReportController@singleTransaction')->name('admin.transactions.single');
        Route::post('/transactions-report/range', 'ReportController@rangeTransaction')->name('admin.transactions.range');
        
        Route::get('/debtors-report', 'ReportController@debtor')->name('admin.debtors');
        Route::post('/debtors-report/reminder', 'ReportController@sendDebtorReminder')->name('admin.debtors.sendreminder');

        Route::get('/full-payers-report', 'ReportController@fullPayer')->name('admin.fullpayers');

        Route::get('/service-transactions-report', 'ReportController@serviceTransaction')->name('admin.service.transactions');
        Route::get('/service-transactions-report/all', 'ReportController@serviceAllTransaction')->name('admin.service.transactions.all');
        Route::get('/service-transactions-report/today', 'ReportController@serviceTodayTransaction')->name('admin.service.transactions.today');
        Route::get('/service-transactions-report/week', 'ReportController@serviceWeekTransaction')->name('admin.service.transactions.week');
        Route::get('/service-transactions-report/month', 'ReportController@serviceMonthTransaction')->name('admin.service.transactions.month');
        Route::get('/service-transactions-report/year', 'ReportController@serviceYearTransaction')->name('admin.service.transactions.year');
        Route::post('/service-transactions-report/single', 'ReportController@serviceSingleTransaction')->name('admin.service.transactions.single');
        Route::post('/service-transactions-report/range', 'ReportController@serviceRangeTransaction')->name('admin.service.transactions.range');
                
        Route::get('/cash-flow-report', 'ReportController@cashFlow')->name('admin.cash.flow');
        Route::get('/cash-flow-report/all', 'ReportController@allCashFlow')->name('admin.cash.flow.all');
        Route::post('/cash-flow-report/range', 'ReportController@rangeCashFlow')->name('admin.cash.flow.range');
    });
});


Route::group(['middleware' => ['auth:admin', 'acfront']], function() {
    Route::group(['prefix' => 'admin'], function () {
        /*------- Payments ------- */
        Route::get('/make-payments', 'AdminStudentController@showMakePayment')->name('admin.makepayment');
        Route::post('/make-payments', 'AdminStudentController@storePayment')->name('admin.makepayment.submit');
        Route::get('/receive/{user}/payment', 'AdminStudentController@receivePayment')->name('admin.receivepay');
        Route::post('/receive/payment', 'AdminStudentController@submitPayment')->name('admin.receivepay.submit');
        Route::get('/receive/{payment}/print', 'AdminStudentController@printReceipt')->name('admin.receivepay.receipt');        
    });
});






Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
