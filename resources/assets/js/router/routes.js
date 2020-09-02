const Welcome = () => import('~/pages/welcome').then(m => m.default || m)
const Login = () => import('~/pages/auth/login').then(m => m.default || m)
const Register = () => import('~/pages/auth/register').then(m => m.default || m)
const PasswordEmail = () => import('~/pages/auth/password/email').then(m => m.default || m)
const PasswordReset = () => import('~/pages/auth/password/reset').then(m => m.default || m)
const NotFound = () => import('~/pages/errors/404').then(m => m.default || m)

const Home = () => import('~/pages/home').then(m => m.default || m)
const Settings = () => import('~/pages/settings/index').then(m => m.default || m)
const SettingsProfile = () => import('~/pages/settings/profile').then(m => m.default || m)
const SettingsPassword = () => import('~/pages/settings/password').then(m => m.default || m)
const AdminIndex = () => import('~/pages/admin/admin_index').then(m => m.default || m)
const UsersTable = () => import('~/pages/admin/users_table').then(m => m.default || m)
const ConfirmUser = () => import('~/pages/admin/confirm_user').then(m => m.default || m)
const InventoryPage = () => import('~/pages/inventory_page').then(m => m.default || m)
const Checkout = () => import('~/pages/checkout').then(m => m.default || m)
const OrderSummary = () => import('~/pages/order_summary').then(m => m.default || m)
const OrderDisplay = () => import('~/pages/order_display').then(m => m.default || m)
const ApiTest = () => import('~/pages/api_test').then(m => m.default || m)
const NotConfirmed = () => import('~/pages/not_confirmed').then(m => m.default || m)
const OrdersTable = () => import('~/pages/orders_table').then(m => m.default || m)

export default [
  { path: '/', name: 'home', component: Home },
  { path: '/not_confirmed', name: 'not_confirmed', component: NotConfirmed },
  // { path: '/new_entry', name: 'new_entry', component: NewEntry },
  // { path: '/leaderboard', name: 'leaderboard', component: Leaderboard },

  { path: '/login', name: 'login', component: Login },
  { path: '/inventory_page', name: 'inventory_page', component: InventoryPage },
  { path: '/order_summary/:token', name: 'order_summary', component: OrderSummary, props: true },
  { path: '/order_display/:token', name: 'order_display', component: OrderDisplay, props: true },
  { path: '/checkout', name: 'checkout', component: Checkout },
  { path: '/register', name: 'register', component: Register },
  { path: '/api_test', name: 'apitest', component: ApiTest },
  { path: '/orders_table', name: 'orders_table', component: OrdersTable },
  { path: '/password/reset', name: 'password.request', component: PasswordEmail },
  { path: '/password/reset/:token', name: 'password.reset', component: PasswordReset },

  { path: '/settings',
    component: Settings,
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profile', name: 'settings.profile', component: SettingsProfile },
      { path: 'password', name: 'settings.password', component: SettingsPassword },
    ] },

  { path: '/admin',
    component: AdminIndex,
    children: [
      { path: '', redirect: { name: 'admin.users_table' } },
      { path: 'users_table', name: 'admin.users_table', component: UsersTable },
      { path: 'confirm_user', name: 'admin.confirm_user', component: ConfirmUser },
      // { path: 'password', name: 'settings.password', component: SettingsPassword },
    ] },

  { path: '*', component: NotFound }
]
