/**  FrontEnd **/

//auth
import LoginFront from "./pages/front/auth/Login";
import ForgotPassword from "./pages/front/auth/ForgotPassword";
import ResetPassword from "./pages/front/auth/ResetPassword";
import RegisterFront from "./pages/front/auth/Register";
import RegisterFrontTrainee from "./pages/front/auth/RegisterTrainee";

//home
import Home from "./pages/front/Home";
import Courses from "./pages/front/courses/Index";
import SingleCourse from "./pages/front/courses/SingleCourse";
import RegistrationCourse from "./pages/front/courses/RegistrationCourse";
import MyCourses from "./pages/front/courses/MyCourses";
import Trainers from "./pages/front/trainers/Index";
import Contact from "./pages/front/contact/Index";
import Profiles from "./pages/front/profiles/Index";
import myProfile from "./pages/front/profiles/Index";
import myFavorite from "./pages/front/profiles/Favorites";
import paymentIndex from "./pages/front/payments/Index";
import paymentView from "./pages/front/payments/View";


export default [
    {
        path: '/auth/login',
        name: 'Login',
        component: LoginFront
    },
    {
        path: '/auth/forgot-password',
        name: 'ForgotPassword',
        component: ForgotPassword
    },
    {
        path: '/auth/reset-password/:token',
        name: 'resetPassword',
        component: ResetPassword
    },
    {
        path: '/auth/register',
        name: 'Register',
        component: RegisterFront
    },
    {
        path: '/auth/registertrainee',
        name: 'RegisterTrainee',
        component: RegisterFrontTrainee
    },
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/courses',
        name: 'Courses',
        component: Courses
    },
    {
        path: '/courses/single_course/:id',
        name: 'Single Course',
        component: SingleCourse
    },
    {
        path: '/courses/registration_link/:id',
        name: 'Registration Course',
        component: RegistrationCourse
    },
    {
        path: '/courses/my_courses/:id',
        name: 'My Course',
        component: MyCourses
    },
    {
        path: '/trainers',
        name: 'Trainers',
        component: Trainers
    },
    {
        path: '/contact',
        name: 'Contact',
        component: Contact
    },
    {
        path: '/trainer/profile/:id',
        name: 'Profile',
        component: Profiles
    },{
        path: '/profile',
        name: 'Profile',
        component: myProfile
    },{
        path: '/myFavorite',
        name: 'My Favorite',
        component: myFavorite
    },{
        path: '/payment',
        name: 'Payment',
        component: paymentIndex
    },
    {
        path: '/payment/view/',
        name: 'Payment View',
        component: paymentView
    },
];
