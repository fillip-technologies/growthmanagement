# Growth Management Laravel ERP - Read-Only Role & Access Audit

Audit date: 2026-08-13  
Scope: factual role/access audit only. No backend, frontend, routes, controllers, models, migrations, or database records were modified for this audit.

## Evidence Inspected

- `config/auth.php`
- `bootstrap/app.php`
- `routes/AdminRoute.php`
- `routes/EmployeeRoute.php`
- `routes/HrManagerRoute.php`
- `routes/MarketingManagerRoute.php`
- `routes/SalesManagerRoute.php`
- `routes/TeamLeaderRoute.php`
- `routes/AccountManagerRoute.php`
- `routes/ProjectManagerRoute.php`
- `routes/api.php`
- `app/Http/Middleware/*`
- `app/Http/Controllers/*`
- `app/Helpers/AuthCheckHelper.php`
- `app/Helpers/UniversalHelper.php`
- `resources/views/admin/include/sidebar.blade.php`
- `resources/views/admin/dashboard.blade.php`
- `app/Models/*`
- `database/migrations/*`
- `growthmanegemant (6).sql`

## Executive Role Count

EXACT number of application roles currently implemented in active login/guard code: 8.

Roles implemented through login logic, session guards, middleware aliases, helper functions, sidebar checks, and SQL user data:

1. `super_admin`
2. `employee`
3. `project_manager`
4. `team_leader`
5. `marketing_manager`
6. `account_manager`
7. `hr_manager`
8. `sales_manager`

There is also a legacy `roles` table with enum values `admin`, `employee`, `hr`, `intern`, but this is not the active role system used by login guards. The active role value lives on `users.role`.

## Step 1 - All Roles Identified

| Role name | Database value | Where defined | Guard | Middleware | Dashboard route | Status |
|---|---|---|---|---|---|---|
| Super Admin | `super_admin` | `role()` helper, `users.role` enum SQL, login controller, auth guard | `super_admin` | `super_admin` alias using `AdminAuthMiddleware` | `admin.dashboard` | Active |
| Employee | `employee` | `role()` helper, `users.role` enum SQL, login controller, auth guard | `employee` | `employee` alias using `EmployeeAuthMiddleware` | `employee.dashboard` | Active |
| Project Manager | `project_manager` | `role()` helper, `users.role` enum SQL, login controller, auth guard | `project_manager` | `project_manager` alias exists, but admin route group uses `super_admin` middleware that also allows project manager | `admin.dashboard` after login | Active but routing is mixed |
| Team Leader | `team_leader` | `role()` helper, `users.role` enum SQL, login controller, auth guard | `team_leader` | `team_leader` alias using `TeamLeaderMiddleware` | `teamhead.dashboard` | Active |
| Marketing Manager | `marketing_manager` | `role()` helper, `users.role` enum SQL, login controller, auth guard | `marketing_manager` | `marketing_manager` alias using `MarketingManagerMiddleware` | `marketing.dashboard` | Active |
| Account Manager | `account_manager` | `role()` helper, SQL users enum, login controller, auth guard | `account_manager` | `account_manager` alias using `AccountManagerMiddleware` | `acmanager.dashboard` | Active |
| HR Manager | `hr_manager` | `role()` helper, `users.role` enum SQL, login controller, auth guard | `hr_manager` | `hr_manager` alias using `HrManagerMiddleware` | `hr.dashboard` | Active |
| Sales Manager | `sales_manager` | `role()` helper, `users.role` enum SQL, login controller, auth guard | `sales_manager` | `sales_manager` alias using `SalesManagerMiddleware` | `sales_manager.dashboard` | Active |

### Role Definition Notes

- `app/Helpers/UniversalHelper.php` returns all 8 role labels.
- `config/auth.php` defines guards for all 8 active roles plus the default `web` guard.
- `bootstrap/app.php` registers middleware aliases for all 8 active role names.
- `database/migrations/2026_07_04_100016_add_colum_to_role_to_table.php` defines a `users.role` enum with 7 roles and misses `account_manager`; however, the SQL dump includes `account_manager` in the final `users.role` enum.
- `database/migrations/2026_05_05_053103_create_roles_table.php` defines a separate legacy roles table with `admin`, `employee`, `hr`, `intern`. This does not match the active guard role system.
- `routes/ProjectManagerRoute.php` is empty. Project manager access currently comes through login redirect to `admin.dashboard` and `AdminAuthMiddleware`, which allows either `super_admin` or `project_manager`.

## Authentication And Middleware

### Guards

Session guards are configured for:

- `web`
- `super_admin`
- `employee`
- `hr_manager`
- `sales_manager`
- `marketing_manager`
- `project_manager`
- `team_leader`
- `account_manager`

All guards use the same Eloquent provider and the same `App\Models\User` model.

### Middleware Behavior

| Middleware alias | Class | Actual check |
|---|---|---|
| `super_admin` | `AdminAuthMiddleware` | Allows `Auth::guard('super_admin')->check()` OR `Auth::guard('project_manager')->check()` |
| `employee` | `EmployeeAuthMiddleware` | Allows employee guard only |
| `hr_manager` | `HrManagerMiddleware` | Allows HR manager guard only |
| `team_leader` | `TeamLeaderMiddleware` | Allows team leader guard only |
| `project_manager` | `ProjectManagerManagerMiddleware` | Allows project manager guard only, but no route group currently uses it |
| `sales_manager` | `SalesManagerMiddleware` | Allows sales manager guard only |
| `marketing_manager` | `MarketingManagerMiddleware` | Allows marketing manager guard only |
| `account_manager` | `AccountManagerMiddleware` | Allows account manager guard only |

### Policies/Gates/Permission Tables

- Policies: Not found.
- Gates: Not found.
- `@can`: Not found.
- Permission table: Not found.
- Fine-grained permission checks: Not found.
- Actual authorization style: mixed route middleware plus Blade sidebar visibility plus some controller guard checks.

## Login Routing

Public login routes:

- `GET /` -> `AdminController@login_admin` -> `admin.login.signin`
- `POST /login` -> `LoginController@login` -> role-based guard attempt

`LoginController@login` reads `User::where('email', $request->email)->first()` and then branches on `$checkdata->role`.

Dashboard redirects after login:

| User role | Login redirect |
|---|---|
| `super_admin` | `admin.dashboard` |
| `employee` | `employee.dashboard` |
| `team_leader` | `teamhead.dashboard` |
| `project_manager` | `admin.dashboard` |
| `hr_manager` | `hr.dashboard` |
| `marketing_manager` | `marketing.dashboard` |
| `account_manager` | `acmanager.dashboard` |
| `sales_manager` | `sales_manager.dashboard` |

## Sidebar Matrix

Source: `resources/views/admin/include/sidebar.blade.php`

| Role | Dashboard | Projects | Attendance | Tasks | Leaves | Leads | Employees | Reports | Other |
|---|---|---|---|---|---|---|---|---|---|
| Super Admin | YES | YES | YES | Drag Task | YES | YES | YES | YES + Weekly Reports | None |
| Project Manager | Sidebar YES but dashboard link points to `employee.dashboard` | YES | YES | Drag Task | YES | YES | YES | YES + Weekly Reports | None |
| Employee | YES | NO | YES own attendance | My Tasks | Leave apply through attendance page | NO | NO | NO | Sales employee sees sales task route if department is Sales Department |
| Team Leader | YES | Project info route only | YES attendance list | My Tasks + Assigned Tasks | NO | NO | Team Members | YES | Project information from attendance |
| Account Manager | YES | NO | NO | Sales/department assignment pages | NO | All Leads + Lead Datas | Sales/team lists | Sales Reports | Sales Team, IT/Marketing Team assignment |
| Marketing Manager | YES | YES | NO | My Tasks + Drag Task | NO | Client Leads | Team Members | Marketing Report | Can edit/delete employees through routes |
| HR Manager | YES | Project info route only | YES + export | NO | YES | NO | NO | NO | Leave approve/reject/delete |
| Sales Manager | YES | NO | NO | My Tasks + assign form route exists | NO | NO direct lead create/edit | BDA Employees | Sales Reports | Assign sales tasks |

Important sidebar/access mismatch:

- For `project_manager`, sidebar dashboard variable is set to `route('employee.dashboard')`, but login redirects project managers to `route('admin.dashboard')`. The `employee.dashboard` route is protected by employee middleware, so project manager clicking Dashboard in sidebar can be blocked/redirected.

## Dashboard Matrix

Most role dashboards render the same view: `resources/views/admin/dashboard.blade.php`.

| Role | Dashboard Route | Controller/Closure | View | Data Sources | Real Data | Mock Data |
|---|---|---|---|---|---|---|
| Super Admin | `admin.dashboard` | Closure in `AdminRoute.php` | `admin.dashboard` | `User`, `AddTask`, `Project`, `AssingTask`, `LeadCreate` | Counts and revenue are real DB queries | Growth percentages use `rand()`, recent activity text is hardcoded |
| Project Manager | `admin.dashboard` | Closure in `AdminRoute.php` through `super_admin` middleware | `admin.dashboard` | Same view; super-admin-only block not shown unless guard check is super_admin | Greeting uses project manager name | Many dashboard widgets are not shown because view checks super_admin for major stats |
| Employee | `employee.dashboard` | Closure in `EmployeeRoute.php` | `admin.dashboard` | Same view | Greeting uses employee name | Many widgets are mock/hidden by guard conditions |
| Team Leader | `teamhead.dashboard` | Closure in `TeamLeaderRoute.php` | `admin.dashboard` | Same view | Greeting uses team leader name | Many widgets are mock/hidden |
| Marketing Manager | `marketing.dashboard` | Closure in `MarketingManagerRoute.php` | `admin.dashboard` | Same view | Name may not be set in dashboard greeting because dashboard PHP only checks super_admin/team_leader/project_manager/employee | Many widgets are mock/hidden |
| Account Manager | `acmanager.dashboard` | Closure in `AccountManagerRoute.php` | `admin.dashboard` | Same view | Name may not be set in dashboard greeting | Many widgets are mock/hidden |
| HR Manager | `hr.dashboard` | Closure in `HrManagerRoute.php` | `admin.dashboard` | Same view | Name may not be set in dashboard greeting | Many widgets are mock/hidden |
| Sales Manager | `sales_manager.dashboard` | Closure in `SalesManagerRoute.php` | `admin.dashboard` | Same view | Name may not be set in dashboard greeting | Many widgets are mock/hidden |

Dashboard displays currently include:

- Greeting based on current hour.
- Date.
- For super admin: total users, total projects, converted lead revenue, total tasks.
- Recent Activity: hardcoded example items.
- Quick Actions: Create New Project, Add Employee, Assign Tasks, View Attendance.
- Other chart/activity sections exist in the Blade file and are primarily UI/dashboard display.

## Role-By-Role Audit

## ROLE: Super Admin

Dashboard:

- Route: `admin.dashboard`
- Controller: closure in `routes/AdminRoute.php`
- View: `admin.dashboard`
- Displayed: greeting, DB count cards, revenue sum, task/project/user totals, quick actions, hardcoded recent activity.

Sidebar/Menu:

- Dashboard -> `admin.dashboard`
- Projects -> `project.list`
- Attendance -> `attendanceList`
- Drag Task -> `drag.task`
- Leaves -> `leaveList`
- Leads -> `admin.clientLeads`
- Employees -> `employees`
- Reports -> `report`
- Weekly Reports -> `week.report`

Modules/actions:

| Module | View | Create | Edit | Delete | Approve | Assign | Export | Status Change |
|---|---|---|---|---|---|---|---|---|
| Employees | YES `employees` | YES `add.employees` | YES `update.employees` | YES `destroy` | Not found | Not found | Not found | YES user `status` field |
| Projects | YES `project.list` | YES `project.store` | YES `project.update` | YES `project.delete` | Not found | Adds project to task pool via `addtotask` | Not found | YES project `status` |
| Drag Task | YES `drag.task` | YES assignment creates `AssingTask` | Not found | YES delete assigned task/add task | Not found | YES `assignDragTask` | Not found | Not found |
| Legacy Tasks | YES `task` | YES `add.task` | YES `tasks.update` | YES `tasks.delete` | Not found | YES assigned_to in task form | Not found | YES task status/progress |
| Daily Work | YES route exists | YES | YES | Not found | Not found | Not found | Not found | Module progress updated |
| Attendance | YES list | Not directly; employee records create own attendance | View/filter | UI edit icon only in list | Not found | Not found | YES `attendance.export` | Filter by status/date |
| Leaves | YES `leaveList` | Not found | Not found | YES `status.delete` | YES approve/reject | Not found | Not found | YES approved/reject |
| Leads external | YES `admin.clientLeads` | Not found | Not found | Not found | Not found | Not found | Not found | Search external API list |
| Reports | YES `report`, `week.report` | Not found | Not found | Not found | Not found | Not found | Not found | View progress/report rows |
| Chat | Routes exist | YES send admin SMS | Not found | Not found | Not found | Not found | Not found | Fetch chat by project |

Data access:

- Can view all non-super-admin users.
- Can create/update/delete users.
- Can create/update/delete projects.
- Can view all AddTask report rows.
- Can view all attendance.
- Can export all attendance.
- Can approve/reject/delete leave records.
- Can assign project tasks to users.

Approval capabilities:

- Leave approve/reject/delete implemented.

## ROLE: Project Manager

Dashboard:

- Route after login: `admin.dashboard`.
- Controller: closure in `routes/AdminRoute.php`.
- View: `admin.dashboard`.
- Displayed: same dashboard view, but super-admin-only sections are not fully rendered for project_manager.

Sidebar/Menu:

- Dashboard variable points to `employee.dashboard` in sidebar, which is likely route-blocked for project manager.
- Projects -> `project.list`
- Attendance -> `attendanceList`
- Drag Task -> `drag.task`
- Leaves -> `leaveList`
- Leads -> `admin.clientLeads`
- Employees -> `employees`
- Reports -> `report`
- Weekly Reports -> `week.report`

Implementation detail:

- `ProjectManagerRoute.php` is empty.
- `ProjectManagerManagerMiddleware` exists but no project manager route group uses it.
- Admin route group uses `super_admin` middleware, and that middleware explicitly allows `project_manager`.

Modules/actions:

| Module | View | Create | Edit | Delete | Approve | Assign | Export | Status Change |
|---|---|---|---|---|---|---|---|---|
| Employees | YES through admin route group | YES | YES | YES | Not found | Not found | Not found | YES |
| Projects | YES | YES | YES | YES | Not found | Adds project to task pool | Not found | YES |
| Drag Task | YES | YES assign | Not found | YES | Not found | YES | Not found | Not found |
| Legacy Tasks | YES | YES | YES | YES | Not found | YES | Not found | YES |
| Attendance | YES | Not found | View/filter | UI-only edit icon in list | Not found | Not found | YES via admin route | Filter |
| Leaves | YES | Not found | Not found | YES | YES | Not found | Not found | YES |
| Leads external | YES | Not found | Not found | Not found | Not found | Not found | Not found | Search external API |
| Reports | YES | Not found | Not found | Not found | Not found | Not found | Not found | View |
| Chat | YES routes inherited | YES admin chat | Not found | Not found | Not found | Not found | Not found | Fetch |

Data access:

- Effectively broad admin-like access because `AdminAuthMiddleware` allows project manager into the admin route group.

Approval capabilities:

- Leave approve/reject/delete through inherited admin route group.

## ROLE: Employee

Dashboard:

- Route: `employee.dashboard`
- Controller: closure in `routes/EmployeeRoute.php`
- View: `admin.dashboard`
- Displayed: common dashboard view; employee name is used in greeting.

Sidebar/Menu:

- Dashboard -> `employee.dashboard`
- Attendance -> `emp.attendance`
- My Tasks -> if department is `Sales Department`, route is `salesEmpTask`; otherwise route is `employee.task`.

Modules/actions:

| Module | View | Create | Edit | Delete | Approve | Assign | Export | Status Change |
|---|---|---|---|---|---|---|---|---|
| Attendance | YES own attendance page | YES start work/lunch/today work/leave apply | Routes exist for attendance edit/update | Route exists for delete | Not found | Not found | Not found | YES daily status |
| Project Tasks | YES assigned tasks | Not found | Updates project status/progress via `employee.status` | Not found | Not found | Not found | Not found | YES project status and AddTask progress |
| Sales Tasks | YES if Sales Department | Not found | YES update sales work/status via `updateWorks` | Not found | Not found | Not found | Not found | YES lead_status |
| Marketing Employee Task | Route exists `mrkempgetTask` | Not found in inspected controller output | Not found | Not found | Not found | Not found | Not found | Not found |
| Chat | YES routes for employee chat | YES employee message | Not found | Not found | Not found | Not found | Not found | Fetch chat |
| Leaves | Through attendance page | YES `TakeLeave` | Not found | Not found | Not found | Not found | Not found | Leave created pending/default |

Data access:

- Can view own assigned project tasks.
- Can view own attendance history.
- Can create/update own attendance entries.
- Can apply for leave.
- Sales Department employees can view/update assigned sales tasks.

Approval capabilities:

- Not found.

## ROLE: Team Leader

Dashboard:

- Route: `teamhead.dashboard`
- Controller: closure in `routes/TeamLeaderRoute.php`
- View: `admin.dashboard`
- Displayed: common dashboard view with team leader name in greeting.

Sidebar/Menu:

- Dashboard -> `teamhead.dashboard`
- Team Members -> `teammember`
- My Tasks -> `teamhead.employee.task`
- Assigned Tasks -> `teamhead.drag.task`
- Reports -> `teamhead.report`
- Attendance -> `teamhead.attendanceList`

Modules/actions:

| Module | View | Create | Edit | Delete | Approve | Assign | Export | Status Change |
|---|---|---|---|---|---|---|---|---|
| Team Members | YES IT Department employees | Not found | Not found from teamhead routes | Not found | Not found | Not found | Not found | Not found |
| My Tasks | YES own assigned tasks and TeamHeadTask | Not found | Employee status update route not present under teamhead | Not found | Not found | Not found | Not found | UI may show update forms from shared view |
| Drag Task | YES | YES assign project tasks to IT Department employees | Not found | YES assigned task delete | Not found | YES `teamhead.assignDragTask` | Not found | Not found |
| Attendance | YES all attendance list via `AdminController@attendanceList` | Not found | Not found | Not found | Not found | Not found | Not found | Filter |
| Reports | YES project/task report via `Teamheadreport` | Not found | Not found | Not found | Not found | Not found | Not found | View |
| Project Info | YES attendance detail route | Not found | Not found | Not found | Not found | Not found | Not found | View |

Data access:

- Team members page filters users where `role = employee` and `department = IT Department`.
- Drag task employee list filters IT Department employees.
- Report reads AddTask records with project/user.
- Attendance list uses all attendance list query.

Approval capabilities:

- Not found.

## ROLE: Marketing Manager

Dashboard:

- Route: `marketing.dashboard`
- Controller: closure in `routes/MarketingManagerRoute.php`
- View: `admin.dashboard`
- Displayed: common dashboard; dashboard greeting code does not explicitly set marketing manager name.

Sidebar/Menu:

- Dashboard -> `marketing.dashboard`
- Team Members -> `marketing.teammember`
- My Tasks -> `marketing.employee.task`
- Leads -> `marketing.clientLeads`
- Projects -> `marketing.project.list`
- Assigned Tasks -> `marketing.drag.task`
- Reports -> `marketing.report`

Modules/actions:

| Module | View | Create | Edit | Delete | Approve | Assign | Export | Status Change |
|---|---|---|---|---|---|---|---|---|
| Team Members | YES Marketing Department employees | Not found in sidebar | YES route exists `marketing.update.employees` | YES route exists `marketing.destroy` | Not found | Not found | Not found | YES employee status through shared update |
| My Tasks | YES shared employee task view | Not found | Potential shared status UI depending view route availability | Not found | Not found | Not found | Not found | Not clearly route-backed |
| Leads external | YES `marketing.clientLeads` | Not found | Not found | Not found | Not found | Not found | Not found | Search external API |
| Projects | YES | YES | YES | YES | Not found | AddTask created on project creation | Not found | YES project status |
| Drag Task | YES marketing scoped tasks | YES assign to Marketing Department employees | Not found | YES assigned task delete | Not found | YES `marketing.assignDragTask` | Not found | Not found |
| Reports | YES marketing report | Not found | Not found | Not found | Not found | Not found | Not found | View |

Data access:

- Can see marketing department employees.
- Can create/edit/delete projects through same `ProjectController` as admin.
- Marketing drag task only loads AddTask where related project `created_by` equals logged marketing manager id.
- Reports filter AddTask where assigned user department is Marketing Department.

Approval capabilities:

- Not found.

## ROLE: Account Manager

Dashboard:

- Route: `acmanager.dashboard`
- Controller: closure in `routes/AccountManagerRoute.php`
- View: `admin.dashboard`
- Displayed: common dashboard; dashboard greeting code does not explicitly set account manager name.

Sidebar/Menu:

- Dashboard -> `acmanager.dashboard`
- All Leads -> `leadedata`
- Lead Datas -> `index`
- Team Members -> `sales.employee`
- Sales Team -> `projectuser`
- IT/Marketing Team -> `headTaskassing`
- Reports -> `reportforsales`

Modules/actions:

| Module | View | Create | Edit | Delete | Approve | Assign | Export | Status Change |
|---|---|---|---|---|---|---|---|---|
| External Leads | YES `leadedata` | Not found | Not found | Not found | Not found | Not found | Not found | Search external API |
| Local Leads | YES `index` | YES `createLeadsdata` | YES `leadUpdate` | YES `leaddelete` | Not found | Not found | Not found | YES lead_status |
| Sales Employees | YES Sales Department employees | Not found | Not found | Not found | Not found | Not found | Not found | View |
| Assign to Sales Manager | YES `projectuser` | YES creates `TaskforSales` | Not found | Not found | Not found | YES `assingtaskforsales` | Not found | Not found |
| Assign converted leads to IT/Marketing | YES `headTaskassing` | YES creates/updates `TeamHeadTask` | Not found | Not found | Not found | YES `asingtaskdepart` | Not found | Not found |
| Reports | YES all sales task reports | Not found | Not found | Not found | Not found | Not found | Not found | View details |

Data access:

- Can fetch external leads from `https://version2.filliptechnologies.com/api/integrations/leads`.
- Can create, list, edit, delete local `LeadCreate` records.
- Can assign lead tasks to `sales_manager`.
- Can assign converted leads to users with role `team_leader` or `marketing_manager`.
- Can view all TaskforSales report rows.

Approval capabilities:

- Not found.

## ROLE: HR Manager

Dashboard:

- Route: `hr.dashboard`
- Controller: closure in `routes/HrManagerRoute.php`
- View: `admin.dashboard`
- Displayed: common dashboard; dashboard greeting code does not explicitly set HR manager name.

Sidebar/Menu:

- Dashboard -> `hr.dashboard`
- Attendance -> `hr.attendanceList`
- Leaves -> `hr.leaveList`

Modules/actions:

| Module | View | Create | Edit | Delete | Approve | Assign | Export | Status Change |
|---|---|---|---|---|---|---|---|---|
| Attendance | YES all attendance list | Not found | Not found | Not found | Not found | Not found | YES `hr.attendance.export` | Filter by status/date |
| Leaves | YES leave list | Not found | Not found | YES `hr.status.delete` | YES `hr.status.approved`, `hr.status.reject` | Not found | Not found | YES |
| Project Info | YES via attendance detail route | Not found | Not found | Not found | Not found | Not found | Not found | View |

Data access:

- Can view all attendance list.
- Can export attendance.
- Can view all leave applications.
- Can approve, reject, delete leave applications.

Approval capabilities:

- Leave approve/reject/delete implemented.

## ROLE: Sales Manager

Dashboard:

- Route: `sales_manager.dashboard`
- Controller: closure in `routes/SalesManagerRoute.php`
- View: `admin.dashboard`
- Displayed: common dashboard; dashboard greeting code does not explicitly set sales manager name.

Sidebar/Menu:

- Dashboard -> `sales_manager.dashboard`
- Team Members -> `bda.employees`
- My Tasks -> `mytask`
- Reports -> `sales.reportforsales`

Route exists but sidebar does not show:

- `assingform`
- `sales.assingtaskforsales`

Modules/actions:

| Module | View | Create | Edit | Delete | Approve | Assign | Export | Status Change |
|---|---|---|---|---|---|---|---|---|
| BDA Employees | YES Sales Department employees | Not found | Not found | Not found | Not found | Not found | Not found | View |
| My Sales Tasks | YES tasks where `user_id` is sales manager id | Not found | Not found | Not found | Not found | Not found | Not found | View |
| Assign Sales Tasks | Route/form exists | YES creates `TaskforSales` | Not found | Not found | Not found | YES route exists | Not found | Not found |
| Sales Reports | YES reports assigned by logged sales manager | Not found | Not found | Not found | Not found | Not found | Not found | View details |

Data access:

- Can view Sales Department employees.
- Can view sales tasks assigned to self.
- Can create sales tasks if route/form is accessed.
- Can view reports for tasks where `assing_by` equals logged sales manager id.

Approval capabilities:

- Not found.

## Route Access Matrix

Important routes grouped by actual middleware.

| Role | Module | Route | View | Create | Edit | Delete | Approve | Assign | Export |
|---|---|---|---|---|---|---|---|---|---|
| Super Admin | Dashboard | `GET admin/admin/dashboard` | YES | NO | NO | NO | NO | NO | NO |
| Super Admin | Employees | `GET admin/get/all` | YES | NO | NO | NO | NO | NO | NO |
| Super Admin | Employees | `GET admin/create/emp` | YES | Form | NO | NO | NO | NO | NO |
| Super Admin | Employees | `POST admin/store` | NO | YES | NO | NO | NO | NO | NO |
| Super Admin | Employees | `GET admin/emp/{id}` | YES | NO | Form | NO | NO | NO | NO |
| Super Admin | Employees | `POST admin/update/employees/{id}` | NO | NO | YES | NO | NO | NO | NO |
| Super Admin | Employees | `DELETE admin/employees/{id}` | NO | NO | NO | YES | NO | NO | NO |
| Super Admin | Projects | `GET admin/project/list` | YES | NO | NO | NO | NO | NO | NO |
| Super Admin | Projects | `GET admin/project/create` | YES | Form | NO | NO | NO | NO | NO |
| Super Admin | Projects | `POST admin/project/store` | NO | YES | NO | NO | NO | NO | NO |
| Super Admin | Projects | `GET admin/project/edit/{id}` | YES | NO | Form | NO | NO | NO | NO |
| Super Admin | Projects | `POST admin/project/update/{id}` | NO | NO | YES | NO | NO | NO | NO |
| Super Admin | Projects | `DELETE admin/product/delete/{id}` | NO | NO | NO | YES | NO | NO | NO |
| Super Admin | Task Assignment | `GET admin/drag/task` | YES | NO | NO | NO | NO | NO | NO |
| Super Admin | Task Assignment | `POST admin/assing/drag/task` | NO | YES assignment | NO | NO | NO | YES | NO |
| Super Admin | Task Assignment | `GET admin/delete/assing/task` | NO | NO | NO | YES | NO | NO | NO |
| Super Admin | Attendance | `GET admin/attendanceList` | YES | NO | NO | NO | NO | NO | NO |
| Super Admin | Attendance | `GET admin/attendance/export` | NO | NO | NO | NO | NO | NO | YES |
| Super Admin | Leaves | `GET admin/leave/live` | YES | NO | NO | NO | NO | NO | NO |
| Super Admin | Leaves | `POST admin/leave/approved` | NO | NO | NO | NO | YES | NO | NO |
| Super Admin | Leaves | `POST admin/leave/reject` | NO | NO | NO | NO | YES | NO | NO |
| Super Admin | Leaves | `DELETE admin/leave/delete` | NO | NO | NO | YES | NO | NO | NO |
| Super Admin | Reports | `GET admin/all/report` | YES | NO | NO | NO | NO | NO | NO |
| Super Admin | Reports | `GET admin/weekly/report` | YES | NO | NO | NO | NO | NO | NO |
| Project Manager | Same admin modules | Same `admin/*` routes | YES | YES | YES | YES | YES leaves | YES | YES attendance |
| Employee | Dashboard | `GET employee/dashboard` | YES | NO | NO | NO | NO | NO | NO |
| Employee | Attendance | `GET employee/attendance` | YES | NO | NO | NO | NO | NO | NO |
| Employee | Attendance | `POST employee/attendance/start-work` | NO | YES attendance | NO | NO | NO | NO | NO |
| Employee | Attendance | `POST employee/attendance/lunch-start` | NO | YES lunch start | NO | NO | NO | NO | NO |
| Employee | Attendance | `POST employee/attendance/lunch-out` | NO | YES lunch out | NO | NO | NO | NO | NO |
| Employee | Attendance | `POST employee/attendance/end-work` | NO | YES end work | NO | NO | NO | NO | NO |
| Employee | Attendance | `POST employee/today/works` | NO | YES today work | NO | NO | NO | NO | NO |
| Employee | Leaves | `POST employee/take/leave` | NO | YES leave | NO | NO | NO | NO | NO |
| Employee | Project Tasks | `GET employee/task` | YES | NO | NO | NO | NO | NO | NO |
| Employee | Project Tasks | `POST employee/assing/project/status` | NO | NO | YES status/progress | NO | NO | NO | NO |
| Employee | Sales Tasks | `GET employee/sales/employee/task` | YES | NO | NO | NO | NO | NO | NO |
| Employee | Sales Tasks | `POST employee/updateWorks` | NO | NO | YES task/lead status | NO | NO | NO | NO |
| Employee | Chat | `POST employee/send/admin/sms` | NO | YES message | NO | NO | NO | NO | NO |
| Employee | Chat | `GET employee/get/sms` | YES JSON | NO | NO | NO | NO | NO | NO |
| Team Leader | Members | `GET teamhead/members` | YES | NO | NO | NO | NO | NO | NO |
| Team Leader | Tasks | `GET teamhead/task` | YES | NO | NO | NO | NO | NO | NO |
| Team Leader | Assign Tasks | `GET teamhead/drag/task` | YES | NO | NO | NO | NO | NO | NO |
| Team Leader | Assign Tasks | `POST teamhead/assing/drag/task` | NO | YES assignment | NO | NO | NO | YES | NO |
| Team Leader | Reports | `GET teamhead/all/report` | YES | NO | NO | NO | NO | NO | NO |
| Team Leader | Attendance | `GET teamhead/attendanceList` | YES | NO | NO | NO | NO | NO | NO |
| Marketing Manager | Members | `GET marketing/manager/members` | YES | NO | NO | NO | NO | NO | NO |
| Marketing Manager | Employees | `POST marketing/manager/update/employees/{id}` | NO | NO | YES | NO | NO | NO | NO |
| Marketing Manager | Employees | `DELETE marketing/manager/employees/{id}` | NO | NO | NO | YES | NO | NO | NO |
| Marketing Manager | Leads | `GET marketing/manager/clientLeads` | YES | NO | NO | NO | NO | NO | NO |
| Marketing Manager | Projects | `GET/POST/DELETE marketing/manager/project/*` | YES | YES | YES | YES | NO | NO | NO |
| Marketing Manager | Assign Tasks | `POST marketing/manager/assing/drag/task` | NO | YES assignment | NO | NO | NO | YES | NO |
| Marketing Manager | Reports | `GET marketing/manager/marketing/report` | YES | NO | NO | NO | NO | NO | NO |
| Account Manager | External Leads | `GET account_manager/leadedata` | YES | NO | NO | NO | NO | NO | NO |
| Account Manager | Local Leads | `GET account_manager/index` | YES | NO | NO | NO | NO | NO | NO |
| Account Manager | Local Leads | `POST account_manager/createLeadsdata` | NO | YES | NO | NO | NO | NO | NO |
| Account Manager | Local Leads | `POST account_manager/leadUpdate/{id}` | NO | NO | YES | NO | NO | NO | NO |
| Account Manager | Local Leads | `DELETE account_manager/leaddelete/{id}` | NO | NO | NO | YES | NO | NO | NO |
| Account Manager | Assign Sales | `POST account_manager/assingtaskforsales` | NO | YES task | NO | NO | NO | YES | NO |
| Account Manager | Assign IT/Marketing | `POST account_manager/asingtaskdepart` | NO | YES TeamHeadTask | YES updateOrCreate | NO | NO | YES | NO |
| Account Manager | Reports | `GET account_manager/reportforsales` | YES | NO | NO | NO | NO | NO | NO |
| HR Manager | Attendance | `GET hr/attendanceList` | YES | NO | NO | NO | NO | NO | NO |
| HR Manager | Attendance | `GET hr/attendance/export` | NO | NO | NO | NO | NO | NO | YES |
| HR Manager | Leaves | `GET hr/leave/live` | YES | NO | NO | NO | NO | NO | NO |
| HR Manager | Leaves | `POST hr/leave/approved` | NO | NO | NO | NO | YES | NO | NO |
| HR Manager | Leaves | `POST hr/leave/reject` | NO | NO | NO | NO | YES | NO | NO |
| HR Manager | Leaves | `DELETE hr/leave/delete` | NO | NO | NO | YES | NO | NO | NO |
| Sales Manager | Employees | `GET sales/manager/bda/employees` | YES | NO | NO | NO | NO | NO | NO |
| Sales Manager | My Tasks | `GET sales/manager/mytask` | YES | NO | NO | NO | NO | NO | NO |
| Sales Manager | Assign Sales Task | `POST sales/manager/assingtaskforsales` | NO | YES task | NO | NO | NO | YES | NO |
| Sales Manager | Reports | `GET sales/manager/reportforsales` | YES | NO | NO | NO | NO | NO | NO |

## Business Responsibilities Based On Code

### Super Admin

- Manages employees/users.
- Manages projects.
- Creates legacy tasks.
- Assigns project tasks via drag/drop.
- Views leads from external API.
- Views reports and weekly reports.
- Views and exports attendance.
- Views, approves, rejects, and deletes leave requests.
- Can use admin chat routes.

### Project Manager

- Has admin-route-level access to projects, employees, attendance, leaves, leads, reports, and task assignment because `AdminAuthMiddleware` permits project manager.
- No separate project manager route group is implemented.
- Sidebar dashboard link is inconsistent and can be route-blocked.

### Employee

- Views dashboard.
- Marks attendance events.
- Adds today work.
- Applies for leave.
- Views own assigned project tasks.
- Updates project status/progress from task view.
- Sends/fetches chat messages.
- If Sales Department, views sales tasks and updates lead/task status.

### Team Leader

- Views IT Department team members.
- Views own assigned tasks.
- Views TeamHeadTask records assigned to self.
- Assigns project tasks to IT Department employees.
- Views reports.
- Views attendance list.
- Views project information from attendance records.

### Marketing Manager

- Views Marketing Department employees.
- Can update/delete employees via exposed routes.
- Views external client leads.
- Creates/edits/deletes projects.
- Assigns project tasks to Marketing Department employees.
- Views marketing report filtered by Marketing Department.

### Account Manager

- Fetches external sales leads.
- Creates, lists, edits, deletes local leads.
- Assigns local leads to Sales Managers.
- Assigns converted leads to Team Leaders or Marketing Managers.
- Views sales task reports and task details.
- Views sales department/team lists.

### HR Manager

- Views attendance list.
- Exports attendance.
- Views leave list.
- Approves, rejects, deletes leave requests.
- Views project information route tied to attendance.

### Sales Manager

- Views Sales Department employees.
- Views own sales tasks.
- Can assign sales tasks through existing route/form.
- Views sales reports assigned by self.
- Views sales task details.

## Role Relationships / Workflows Actually Present

### Login Workflow

User submits email/password -> `LoginController@login` finds `users.email` -> checks `users.role` -> attempts matching guard -> redirects to role dashboard.

### Employee Creation Workflow

Super Admin or any role with exposed employee routes -> employee create form -> `ManegemantController@store` -> creates `User` -> uploads profile/documents -> hashes password -> dispatches `RegistrationEvent` -> `RegistrationListener` emails credentials.

Marketing Manager has exposed update/delete employee routes, but no visible create employee route in sidebar.

### Project Workflow

Super Admin / Project Manager / Marketing Manager -> create project -> `ProjectController@store` creates:

- `projects`
- `project_infra_resources`
- `project_human_resources`
- `add_tasks`

Then project tasks can be assigned through drag/drop:

Project/AddTask -> `DragTaskController@assignDragTask` -> `assing_tasks` -> email sent to assigned user.

### Project Task Workflow

Assigned user -> employee/teamhead/marketing my task page -> views `AssingTask` records -> employee status action calls `EmployeeController@status` -> updates `projects.status`, `add_tasks.progress`, and `add_tasks.employee_id`.

### Lead / CRM Workflow

Account Manager -> external leads from API or local lead create -> local `LeadCreate`.

Account Manager -> assign lead to Sales Manager -> `TaskforSales`.

Sales Manager -> views own `TaskforSales` as my tasks.

Sales Manager can assign a sales task through route -> `TaskforSales`.

Sales Department employee -> views sales tasks assigned to them -> `BusinessManageController@salesEmpTask`.

Sales employee -> update work/status -> updates `TaskforSales.task_des` and `LeadCreate.lead_status`.

Account Manager -> converted leads -> assigns to Team Leader or Marketing Manager -> `TeamHeadTask`.

Team Leader -> `teamhead/task` -> sees `TeamHeadTask` assigned to self.

### Attendance Workflow

Employee -> attendance page -> start work/lunch start/lunch out/end work -> `attendance_infos`.

Employee -> Today Work modal -> adds project/today work to current date attendance.

Admin/HR/Team Leader -> attendance list -> view/filter attendance.

Admin/HR -> export attendance.

### Leave Workflow

Employee -> attendance page -> take leave -> `take_leaves` -> email sent to fixed developer email.

Admin/HR -> leave list -> view leave details -> approve/reject/delete -> updates/deletes `take_leaves`, approval sends email to employee.

### Report Workflow

Admin/Project Manager -> all report -> `AddTask` with project/user.

Team Leader -> report -> `AddTask` with project/user.

Marketing Manager -> report -> `AddTask` filtered by assigned user department = Marketing Department.

Account Manager -> sales task report -> all `TaskforSales`.

Sales Manager -> sales task report -> `TaskforSales` where `assing_by` is logged sales manager id.

## Security / Authorization Audit

Current permission model:

- Guards: YES.
- Middleware: YES, role-specific route groups.
- Policies: Not found.
- Gates: Not found.
- Permission tables: Not found.
- Role checks: YES, hardcoded in login controller, helpers, middleware, views, and selected controllers.
- Blade-only restrictions: YES, sidebar menu visibility depends on guard checks.
- Fine-grained permissions: Not found.

Classification:

- Role-based only: YES.
- Route-based: YES.
- UI-only: YES in sidebar and some view conditions.
- Mixed: YES.
- Fine-grained: NO.

Security/access gaps observed factually:

- `AdminAuthMiddleware` named `super_admin` allows both super admin and project manager, so project managers get broad admin route group access.
- `ProjectManagerRoute.php` is empty despite a middleware and guard existing.
- Sidebar sets project manager dashboard to `employee.dashboard`, which is protected by employee middleware and can be blocked.
- Several controller methods rely on route middleware rather than internal authorization checks.
- Some guard checks use `Auth::guard('role')` without `->check()` in conditions, which always produces a guard object; examples exist in TeamHead/Sales/Marketing controllers.
- No policy/gate layer protects create/edit/delete actions.
- Sidebar visibility is not a full authorization system; route access is controlled mainly by middleware groups.
- API routes use Sanctum authentication but no role-level authorization. Authenticated API users can use user/task CRUD endpoints regardless of role, based on inspected routes/controllers.
- `AccountAccess` model has `protected $table = ""`, so that model appears incomplete.
- Legacy `roles` table values do not match active role guards.
- `LoginController@login` reads `$checkdata->role` without a null check if email is not found.

## Data Objects By Role

| Data model/table | Main roles touching it | Operations |
|---|---|---|
| `users` | Super Admin, Project Manager via admin group, Marketing Manager update/delete routes, Account/Sales/Team/Marketing list pages | Create/edit/delete/list users; filtered team lists |
| `projects` | Super Admin, Project Manager, Marketing Manager, Employee via status update | Create/edit/delete/list/status update |
| `project_infra_resources` | Super Admin, Project Manager, Marketing Manager | Create/update with project |
| `project_human_resources` | Super Admin, Project Manager, Marketing Manager | Create/update with project |
| `add_tasks` | Super Admin, Project Manager, Marketing Manager, Team Leader, Employee | Created with project; assigned; progress updated; reported |
| `assing_tasks` | Super Admin, Project Manager, Marketing Manager, Team Leader, Employee | Assignment records; delete assignment; employee task list |
| `attendance_infos` | Employee, Super Admin, Project Manager, HR Manager, Team Leader | Employee creates/updates own; managers view/export |
| `take_leaves` | Employee, Super Admin, Project Manager, HR Manager | Employee creates; admin/HR approve/reject/delete |
| `lead_creates` | Account Manager, Sales Manager, Sales Employee, Admin/Marketing external only | Local lead CRUD; status update; converted lead routing |
| `taskfor_sales` | Account Manager, Sales Manager, Sales Employee | Sales task assignment, viewing, reporting |
| `team_head_tasks` | Account Manager, Team Leader | Converted lead assignment to team/marketing heads; team head task display |
| `discusses` | Super Admin, Project Manager, Employee | Chat create/fetch by project |
| `tasks` legacy | Super Admin, Project Manager | Legacy task CRUD and progress updates |
| `task_updates` | Super Admin, Project Manager | Updates attached to legacy tasks |
| `reports` | Model exists | No direct active CRUD route found in inspected web routes |
| `performances` | Super Admin/Project Manager via `getempprefarmans` | View performance feedback |

## Final Role Map

### Super Admin

-> Dashboard: `admin.dashboard`  
-> Main responsibility: broad ERP administration  
-> Modules: employees, projects, task assignment, attendance, leaves, leads, reports, chat, daily work, legacy tasks  
-> Actions: view/create/edit/delete users and projects; assign tasks; approve/reject/delete leaves; export attendance; view reports  
-> Reports: all reports and weekly reports  
-> Approval authority: leaves

### Project Manager

-> Dashboard: `admin.dashboard` after login; sidebar dashboard link mismatch to `employee.dashboard`  
-> Main responsibility: admin-like project operations through admin route group  
-> Modules: same admin route group modules due middleware behavior  
-> Actions: project/user/task/leave/admin-route actions available through `super_admin` middleware allowance  
-> Reports: all reports and weekly reports  
-> Approval authority: leaves through admin route group

### Employee

-> Dashboard: `employee.dashboard`  
-> Main responsibility: own attendance, own assigned work, leave application, chat  
-> Modules: attendance, my tasks, sales tasks if Sales Department, chat  
-> Actions: start/lunch/end work; submit today work; apply leave; update assigned task/project status; sales employee can update lead status  
-> Reports: not in sidebar  
-> Approval authority: none found

### Team Leader

-> Dashboard: `teamhead.dashboard`  
-> Main responsibility: IT team task assignment and monitoring  
-> Modules: team members, my tasks, drag assignment, reports, attendance list  
-> Actions: view IT employees; assign project tasks to IT employees; delete assignments; view reports/attendance  
-> Reports: teamhead report  
-> Approval authority: none found

### Marketing Manager

-> Dashboard: `marketing.dashboard`  
-> Main responsibility: marketing team/projects/tasks and marketing reports  
-> Modules: marketing team members, my tasks, client leads, projects, drag assignment, reports  
-> Actions: create/edit/delete projects; assign tasks to marketing employees; update/delete employees through exposed routes; view external leads; view marketing reports  
-> Reports: marketing report  
-> Approval authority: none found

### Account Manager

-> Dashboard: `acmanager.dashboard`  
-> Main responsibility: lead ownership and lead assignment pipeline  
-> Modules: external leads, local lead data, sales employees, sales team assignment, IT/marketing assignment, sales reports  
-> Actions: create/edit/delete local leads; assign leads to sales manager; assign converted leads to team leader/marketing manager; view reports/details  
-> Reports: sales task reports  
-> Approval authority: none found

### HR Manager

-> Dashboard: `hr.dashboard`  
-> Main responsibility: attendance and leave administration  
-> Modules: attendance, leaves, project info from attendance  
-> Actions: view/filter attendance; export attendance; view/approve/reject/delete leaves  
-> Reports: no dedicated reports menu found  
-> Approval authority: leaves

### Sales Manager

-> Dashboard: `sales_manager.dashboard`  
-> Main responsibility: sales team/task follow-up  
-> Modules: BDA employees, my sales tasks, sales reports, assign-sales-task route exists  
-> Actions: view sales employees; view own sales tasks; create sales tasks through route; view own assigned sales reports  
-> Reports: sales reports filtered by assigning manager  
-> Approval authority: none found

## Answers To Exact Questions

1. EXACT number of roles currently implemented: 8.
2. List every role: `super_admin`, `employee`, `project_manager`, `team_leader`, `marketing_manager`, `account_manager`, `hr_manager`, `sales_manager`.
3. Which role is the highest privileged? `super_admin`. Factually, `project_manager` also has broad admin group access because `AdminAuthMiddleware` allows it.
4. Which role manages employees? `super_admin` and `project_manager` through admin routes. `marketing_manager` has update/delete routes and marketing team listing. Team leader/account manager/sales manager can view filtered employee lists.
5. Which role manages projects? `super_admin`, `project_manager`, `marketing_manager`.
6. Which role assigns project tasks? `super_admin`, `project_manager`, `team_leader`, `marketing_manager`.
7. Which role manages leads? `account_manager` manages local leads. `super_admin` and `marketing_manager` view external client leads.
8. Which role manages sales tasks? `account_manager` assigns sales tasks to sales managers; `sales_manager` has sales task assignment route; Sales Department employees update assigned sales task work/status.
9. Which role manages attendance? Employees create/update their own attendance. `super_admin`, `project_manager`, `hr_manager`, and `team_leader` view attendance lists. `super_admin`/`project_manager`/`hr_manager` can export.
10. Which role manages leaves? Employees create leave applications. `super_admin`, `project_manager`, and `hr_manager` view/manage leave status/delete.
11. Which role can approve/reject leaves? `super_admin`, `project_manager`, `hr_manager`.
12. Which roles can see reports? `super_admin`, `project_manager`, `team_leader`, `marketing_manager`, `account_manager`, `sales_manager`.
13. Which roles can access chat? Web chat routes found for `super_admin`/`project_manager` through admin group and `employee` through employee group. No chat routes found for HR/Marketing/Account/Sales/TeamLeader route groups.
14. Which roles can create/edit/delete projects? `super_admin`, `project_manager`, `marketing_manager`.
15. Which roles can create/edit/delete employees? `super_admin` and `project_manager` can create/edit/delete through admin group. `marketing_manager` has edit/delete employee routes but no create route found in marketing route group.
16. Is there a real permission matrix? No. No permission table, policies, or gates found.
17. Is there a real role-management UI? Not found. A legacy `roles` table/model exists, but no active role-management CRUD UI was found.
18. Are any roles duplicated or overlapping? Yes. `super_admin` and `project_manager` overlap heavily because the admin middleware allows both. `team_leader` and `marketing_manager` both assign project tasks but to different department-scoped users. `account_manager` and `sales_manager` overlap in sales task assignment/reporting.
19. Are any roles partially implemented? Yes. `project_manager` has an empty route file and relies on admin middleware; `roles` table is legacy/mismatched; account access model is incomplete; marketing project-specific controller references separate `marketing.*` views not found in the route/sidebar flow inspected.
20. What is the CURRENT access hierarchy? Super Admin at top; Project Manager has near-admin access through middleware; HR Manager controls attendance/leaves; Account Manager controls lead pipeline assignment; Sales Manager handles sales tasks/team; Marketing Manager handles marketing team/projects/tasks; Team Leader handles IT team tasks; Employee handles own attendance/tasks/leaves.

## Final Classification

Permissions are currently MIXED:

- Route-based by role guard middleware.
- Hardcoded role checks in login, helpers, sidebar, controllers, and views.
- Sidebar visibility controls what users see, but it is not the only access control.
- No fine-grained permission matrix is implemented.
- No policies or gates are implemented.

