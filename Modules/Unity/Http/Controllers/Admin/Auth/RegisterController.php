<?php
namespace Modules\Unity\Http\Controllers\Admin\Auth;

use Illuminate\Support\Facades\Validator;
use Backpack\CRUD\app\Library\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Request as ValidateRequest;
use Modules\Unity\Models\Unity;

class RegisterController extends Controller
{
    protected $data = []; // the information we send to the view

    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    use RegistersUsers;

        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $guard = backpack_guard_name();

        $this->middleware("guest:$guard");

        // Where to redirect users after login / registration.
        $this->redirectTo = property_exists($this, 'redirectTo') ? $this->redirectTo
            : config('backpack.base.route_prefix', 'dashboard');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        //dd($data);
        $user_model_fqn = config('backpack.base.user_model_fqn');
        $user = new $user_model_fqn();
        $users_table = $user->getTable();
        $email_validation = backpack_authentication_column() == 'email' ? 'email|' : '';
        $email_validation = backpack_authentication_column() == 'mobile' ? 'unique:users,mobile|ir_mobile:zero|' : '';


        return Validator::make($data, [
            'name'                             => 'required|max:255',
            backpack_authentication_column()   => 'required|'.$email_validation.'max:255|unique:'.$users_table,
            'password'                         => 'required|min:6|confirmed',
            'fa_name' => 'required|unique:unities,fa_name|max:255',
            'en_name' => 'required|unique:unities,en_name|max:255',
            'national_id' => 'required|integer|unique:unities,national_id',
            'en_address' => 'required|max:400',
            'fa_address' => 'required|max:400',
        ], [], [
            'en_name' => 'نام انگلیسی',
            'fa_name' => 'نام فارسی',
            'fa_address' => 'آدرس فارسی',
            'en_address' => 'آدرس انگلیسی',
            'national_id' => 'شناسه ملی',
            'shahrestan_id' => 'شهر',
            'ostan_id' => 'استان',
            'registration_number' => 'شماره ثبت',
            'registration_date' => 'تاریخ ثبت',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        $user_model_fqn = config('backpack.base.user_model_fqn');
        $user = new $user_model_fqn();

        $unity = Unity::create([
            'fa_name' => $data['fa_name'],
            'en_name' => $data['en_name'],
            'fa_address' => $data['fa_address'],
            'en_address' => $data['en_address'],
            'national_id' => $data['national_id']
        ]);

        return $user->create([
            'name'                             => $data['name'],
            backpack_authentication_column()   => $data[backpack_authentication_column()],
            'password'                         => bcrypt($data['password']),
            'extras'                 => ['unity_id' => $unity->id],
        ]);
    }

    public function showRegistrationForm()
    {

        $this->data['title'] = trans('backpack::base.register'); // set the page title

        return view('unity::auth.register', $this->data);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // if registration is closed, deny access
        // if (! config('backpack.base.registration_open')) {
        //     abort(403, trans('unity::base.registration_closed'));
        // }

        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        event(new Registered($user));

        $user->assignRole('شرکت');

        $this->guard()->login($user);

        return redirect($this->redirectPath());
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return backpack_auth();
    }
}