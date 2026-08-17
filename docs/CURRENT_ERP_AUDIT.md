# Growth Management ERP - Current System Audit

Audit date: 2026-08-13  
Project path: `C:\xampp\htdocs\growthmanagement`  
Scope: read-only audit of existing Laravel ERP. No code changes were made for this audit.

## Executive Snapshot

This is a Laravel ERP / growth management system with one shared `users` table and multiple Laravel session guards. It currently combines employee management, projects, project task assignment, daily attendance, leave management, CRM/leads, sales task assignment, team-head task assignment, reports, chat/message notifications, and a small Sanctum API for users/tasks.

Several areas are real DB-backed modules: authentication, users, projects, task assignment, attendance, leaves, local leads, sales tasks, and reports. Some areas are partial or placeholder: dashboard activity/chart growth values, settings/users static routes, some empty links, project detail view, some marketing-specific controller/views, and incomplete leave status logic.

## Complete Sidebar / Menu Structure

File: `resources/views/admin/include/sidebar.blade.php`

Global first item:
- Dashboard: route changes by authenticated guard.

Super Admin / Project Manager:
- Dashboard
- Projects: `project.list`
- Attendance: `attendanceList`
- Drag Task: `drag.task`
- Leaves: `leaveList`
- Leads: `admin.clientLeads`
- Employees: `employees`
- Reports: `report`
- Weekly Reports: `week.report`
- Commented old dropdowns remain for IT Teams, Sales Teams, DMRK Teams.

Employee:
- Attendance: `emp.attendance`
- My Tasks: `salesEmpTask` for Sales Department employees, otherwise `employee.task`

Team Leader:
- Team Members: `teammember`
- My Tasks: `teamhead.employee.task`
- Assigned Tasks: `teamhead.drag.task`
- Reports: `teamhead.report`
- Attendance: `teamhead.attendanceList`

Account Manager:
- All Leads: `leadedata`
- Lead Datas: `index`
- Team Members: `sales.employee`
- Sales Team: `projectuser`
- IT/Marketing Team: `headTaskassing`
- Reports: `reportforsales`

Marketing Manager:
- Team Members: `marketing.teammember`
- My Tasks: `marketing.employee.task`
- Leads: `marketing.clientLeads`
- Projects: `marketing.project.list`
- Drag Tasks: `marketing.drag.task`
- Reports: `marketing.report`

HR Manager:
- Attendance: `hr.attendanceList`
- Leave Managements: `hr.leaveList`

Sales Manager:
- Leads: empty `href`, appears non-functional UI-only item.
- Team Members: `bda.employees`
- My Tasks: `mytask`
- Reports: `sales.reportforsales`

## Authentication And Authorization

Files:
- `config/auth.php`
- `bootstrap/app.php`
- `app/Http/Middleware/*Middleware.php`
- `app/Http/Controllers/Admin/LoginController.php`
- `resources/views/admin/login/signin.blade.php`

Guards configured against the same `users` provider/table:
- `super_admin`
- `employee`
- `hr_manager`
- `sales_manager`
- `marketing_manager`
- `project_manager`
- `team_leader`
- `account_manager`
- default `web`

Login flow:
- GET `/` -> `admin.login.signin`
- POST `/login` -> `LoginController@login`
- Login attempts each role guard and checks exact `role` string.
- User `status` must be `active`.

Role values from helper:
- `super_admin`
- `employee`
- `project_manager`
- `team_leader`
- `marketing_manager`
- `account_manager`
- `hr_manager`
- `sales_manager`

Authorization:
- Middleware checks whether the corresponding guard is authenticated.
- `super_admin` middleware also allows `project_manager`.
- There is no detailed permission matrix beyond guard checks and role strings.

## Routes / Pages

Registered routes: 164.

Route files loaded by `bootstrap/app.php`:
- `routes/web.php`: effectively empty except imports.
- `routes/api.php`: Sanctum API users/tasks.
- `routes/AdminRoute.php`: login plus super admin/project manager routes.
- `routes/EmployeeRoute.php`: employee attendance, tasks, chat, sales-employee task routes.
- `routes/HrManagerRoute.php`: HR attendance and leave routes.
- `routes/MarketingManagerRoute.php`: marketing manager projects, leads, tasks, team, reports.
- `routes/SalesManagerRoute.php`: sales manager team, tasks, reports.
- `routes/TeamLeaderRoute.php`: team leader members, tasks, drag, report, attendance.
- `routes/AccountManagerRoute.php`: account manager leads, sales assignment, team assignment, reports.
- `routes/ProjectManagerRoute.php`: present but empty.

Static/placeholder routes:
- `admin/users` returns plain text.
- `admin/settings` returns plain text.

## Dashboards

File: `resources/views/admin/dashboard.blade.php`

Routes reusing the same dashboard:
- `admin/admin/dashboard`
- `employee/dashboard`
- `teamhead/dashboard`
- `marketing/manager/dashboard`
- `sales/manager/dashboard`
- `hr/dashboard`
- `account_manager/dashboard`

Super Admin data:
- Total Users: `User::count()`
- Total Projects: `Project::count()`
- Total Revenue: converted lead budget sum
- Total Tasks: `AddTask::count()`
- Project status overview: ongoing/completed/pending project counts

Mock/UI-only dashboard pieces:
- Growth percentages use `rand()`.
- Recent Activity list is hardcoded.
- Some dashboard links use `href="#"`.
- Non-super-admin dashboard shows many zero/hardcoded values.

Status: partially production-ready. Counts are DB-backed in places, but activity/growth/chart pieces are mock.

## Current ERP Map

| Module | Pages | Routes | Main Features | Data | Connections | Status |
|---|---|---|---|---|---|---|
| Auth | login, change password, profile | `/`, `/login`, logout/password routes | Multi-guard login/logout/password update | users | all roles | Mostly real |
| Dashboard | dashboard | per-role dashboard routes | Stats, greeting, quick actions | users/projects/add_tasks/leads plus mock | sidebar/routes | Partial/mock mixed |
| Employees | index/create/edit | admin + marketing employee routes | CRUD, documents, role/department/status | users, roles | tasks/attendance/leads | Real |
| Projects | index/create/edit/view/info | admin + marketing project routes | CRUD, infra, HR resources, modules, status | projects, project_infra_resources, project_human_resources | add_tasks, reports, attendance | Real with partial detail |
| Drag Assignment | dragtask | admin/teamhead/marketing drag routes | Drag/drop assign project tasks | add_tasks, assing_tasks | users/projects/email | Real |
| Project Tasks | employee_task/taskbyhead | employee/teamhead/marketing task routes | Cards, progress/status update, chat | assing_tasks/add_tasks/projects | attendance/reports/chat | Real/partial |
| Legacy Tasks | tasks/* | admin task routes | CRUD, attachments, updates, reports | tasks, task_updates, performances | users/projects/modules | Real but overlapping |
| Attendance | attendance/index/listing | employee/admin/hr/team routes | clock in/out/lunch/today work/export | attendance_infos | users/projects | Real |
| Leaves | leaveList + modal | employee/admin/hr leave routes | apply/view/approve/reject/delete | take_leaves | users/email | Mostly real |
| Leads/CRM | leads/* | account/admin/marketing routes | external leads, local lead CRUD/search | lead_creates + external APIs | sales/team tasks | Real/partial |
| Sales Tasks | sales*, salesemp*, reports | account/sales/employee sales routes | assign/update/report sales lead tasks | taskfor_sales, lead_creates | users/leads | Real |
| Team Head Delivery | completedtask/taskbyhead | account_manager/headTaskassing, teamhead/task | assign converted leads to team/marketing | team_head_tasks, lead_creates | users/leads | Partial-real |
| Reports | reports/*, task reports, sales reports | admin/team/marketing/sales routes | assigned task reports, weekly report, sales reports | assing_tasks/tasks/taskfor_sales | users/projects/leads/chat | Real/overlapping |
| Chat | chat boxes in pages | admin/employee sms routes | send/get discussion messages | discusses | users/projects | Basic real |
| API | api users/tasks | `/api/*` | Sanctum CRUD for users/tasks | users/tasks/tokens | external clients | Basic real |
| Settings | static route only | `admin/settings` | text response | none | none | Placeholder |

## Module Details

### Authentication

What it is for:
- Role-based login into the ERP using a single login page.

Located:
- `app/Http/Controllers/Admin/LoginController.php`
- `resources/views/admin/login/signin.blade.php`
- `config/auth.php`
- `bootstrap/app.php`
- `app/Http/Middleware`

Routes:
- GET `/` `admin`
- POST `/login` `admin.login`
- Role logout routes under admin/employee/hr/teamhead/account/sales.
- Admin password routes: `admin/update/password`, `admin/password/update`

Data:
- `users.email`, `users.password`, `users.role`, `users.status`

Actions:
- Login, logout, password update.

Missing/partial:
- Forgot-password route is not visible in route list.
- No fine-grained permissions beyond middleware role guards.

Status:
- Mostly real.

### Users / Employee Management

What it is for:
- Create, list, edit, delete ERP users/employees.

Located:
- `app/Http/Controllers/ManegemantController.php`
- `resources/views/admin/employees/index.blade.php`
- `resources/views/admin/employees/create.blade.php`
- `resources/views/admin/employees/edit.blade.php`
- `app/Models/User.php`, `app/Models/Role.php`

Routes:
- `admin/get/all`
- `admin/create/emp`
- `admin/store`
- `admin/emp/{id}`
- `admin/update/employees/{id}`
- `admin/employees/{id}`
- Marketing variants: `marketing.show`, `marketing.update.employees`, `marketing.destroy`

Forms / fields:
- name, email, designation, password, profile
- role, phone, status
- employeeID, joinig_date, department
- adhar_card, pan_card, 10th_certificate, 12th_certificate, graduation

Actions:
- Create, edit, update, delete, upload documents.
- Sends registration mail.

Connections:
- Roles, departments, tasks, attendance, leaves, reports, leads.

Missing/partial:
- Role table exists, but role helper hardcodes role list.
- Some field names contain spelling issues (`joinig_date`, `adhar_card`).

Status:
- Real.

### Projects

What it is for:
- Manage client projects, resources, infra, modules, priority, status and timeline.

Located:
- `app/Http/Controllers/Admin/ProjectController.php`
- `resources/views/admin/projects/*`
- `app/Models/Project.php`
- `ProjectHumanResource`, `ProjectInfraResource`, `Module`, `ProjectLog`

Routes:
- `admin/project/list`
- `admin/project/create`
- `admin/project/store`
- `admin/project/edit/{id}`
- `admin/project/update/{id}`
- `admin/product/delete/{id}`
- `admin/view/project/{id}`
- `admin/project/information/{id}`
- Marketing equivalent project routes

Forms / fields:
- name, client_name, description
- project_manager, developer, designer, qa_engineer
- domain_name, domain_registrar, hosting_provider, hosting_account_owner
- ssl_certificate, email_service_provider, dns_management, cdn_provider
- third_party_apis, renewal_date, responsible_team_member
- modules[]
- status: pending, ongoing, completed
- priority: low, medium, high
- start_date, end_date, created_by

Actions:
- Create, edit, update, delete, list, add to task queue, view info.

Workflow:
- Creating a project creates related infra/human resource rows and an `AddTask` queue row.

Missing/partial:
- `projectView($id)` returns a view without passing the project.
- Modules exist as both JSON on `projects.modules` and a separate `modules` table.

Status:
- Real CRUD with partial detail page.

### Drag Task / Assignment

What it is for:
- Assign queued project tasks to employees/team members using drag/drop.

Located:
- `app/Http/Controllers/Task/DragTaskController.php`
- `resources/views/admin/dragTask/dragtask.blade.php`
- `AddTask`, `AssingTask`

Routes:
- Admin: `drag.task`, `assignDragTask`, `deleteAddTask`, `assingdeletetask`
- Team Head: `teamhead.drag.task`, `teamhead.assignDragTask`, `teamhead.assingdeletetask`
- Marketing: `marketing.drag.task`, `marketing.assignDragTask`, `marketing.assingdeletetask`

Fields:
- task_id, employee_id, assigned_by

Actions:
- Assign task, delete queued task, delete assigned task.
- Sends assignment email.

Status:
- Real, but naming typos and GET deletes are present.

### Project / Employee Tasks

What it is for:
- Employees, team leaders, and marketing managers see assigned project work and update status/progress.

Located:
- `app/Http/Controllers/Admin/EmployeeController.php`
- `resources/views/admin/taskList/employee_task.blade.php`
- `resources/views/admin/taskList/taskbyhead.blade.php`

Routes:
- `employee/task`
- `teamhead/task`
- `marketing/manager/task`
- `employee/assing/project/status`

Data:
- `AssingTask` -> `AddTask` -> `Project`
- User assignment data

Fields:
- progress
- status
- employee_id
- project_id

Actions:
- Update project status/progress.
- Open project chat.

Status:
- Real, with some relation null-safety risk.

### Legacy/Admin Tasks

What it is for:
- Separate older task CRUD system with attachments, task updates, performance/report details.

Located:
- `ManegemantController`
- `resources/views/admin/tasks/*`
- `Tasks`, `TaskUpdate`, `Performances`, `Reports`

Routes:
- `admin/task/all`
- `admin/task/form`
- `admin/add/task`
- `admin/task/{id}/edit`
- `admin/task/view/{id}`
- `admin/task/{id}/update`
- `admin/task/{id}/delete`
- `admin/task/update/store`
- `admin/report/{id}/user/{uid}`

Fields:
- title, task_name, project_id, modules[], assigned_to
- description, feedback, attachments[]
- status: pending, in_progress, completed
- priority radio values 1/2/3
- deadline
- update: task_id, description, files[], progress

Actions:
- Create, edit, delete, view, update with files, send task email.

Status:
- Real but overlaps heavily with project assignment tasks.

### Attendance

What it is for:
- Track employee work day, lunch, total hours, status and daily work.

Located:
- `AttendanceInfoController`
- `resources/views/admin/attendance/index.blade.php`
- `resources/views/admin/attendance/listingattendance.blade.php`

Routes:
- `emp.attendance`
- `attendance.start-work`
- `attendance.lunch-start`
- `attendance.lunch-out`
- `attendance.end-work`
- `today.works`
- `dailyAttendance`
- `attendanceList`, `hr.attendanceList`, `teamhead.attendanceList`
- `attendance.export`, `hr.attendance.export`

Fields:
- employee_id, project_id, status, today_works
- start/end/lunch fields are AJAX-controlled.

Actions:
- Start work, lunch start/out, end work, mark attendance status, submit today work, export list.

Status:
- Real.

### Leaves

What it is for:
- Employee leave request and admin/HR approval.

Located:
- `AttendanceInfoController`
- `resources/views/admin/attendance/leaveList.blade.php`
- `TakeLeave`

Routes:
- `TakeLeave`
- `leaveList`, `hr.leaveList`
- `viwe.leave`, `hr.viwe.leave`
- `status.approved`, `hr.status.approved`
- `status.reject`, `hr.status.reject`
- `status.delete`, `hr.status.delete`

Fields:
- employee_id, from_date, to_date, reason

Actions:
- Apply, view modal, approve, reject, delete.
- Emails on apply and approve.

Missing/partial:
- `leaveStatus` method is incomplete.

Status:
- Mostly real.

### Leads / CRM

What it is for:
- External and local lead management for account manager/admin/marketing.

Located:
- `AdminController@clientLeads`
- `SalesManageController`
- `resources/views/admin/leads/*`
- `LeadCreate`

Routes:
- `admin.clientLeads`, `marketing.clientLeads`
- `leadedata`
- `index`
- `createleadform`, `createLeadsdata`
- `editlead`, `leadUpdate`, `leaddelete`

External integrations:
- `https://version2.filliptechnologies.com/api/integrations/leads`
- `https://lead.filliptechnologies.com/api/leadlist`

Fields:
- client_name, name, email, phone, company_name, industry
- services, budget, budget_type, lead_source, lead_status
- message, country, city, pin_code, state, start_date, end_date, created_by

Actions:
- External lead listing/search/pagination.
- Local lead create/list/edit/update/delete.

Status:
- Real local CRUD plus external API listing. Status vocabulary is inconsistent.

### Sales Task Workflow

What it is for:
- Assign leads to sales managers/employees and track sales work/status.

Located:
- `SalesManageController`
- `BusinessManageController`
- `resources/views/admin/leads/*`
- `resources/views/admin/sales/*`
- `resources/views/admin/salesemp/*`
- `TaskforSales`, `LeadCreate`

Routes:
- `projectuser`
- `assingtaskforsales`
- `sales.assingtaskforsales`
- `mytask`
- `salesEmpTask`
- `view.sale.task`
- `updateWorks`
- `reportforsales`, `sales.reportforsales`

Fields:
- leaddata_id, user_id, assing_by, due_date, task_des, priority, lead_status

Workflow:
- Account manager assigns leads to sales manager.
- Sales manager can assign sales work to employees.
- Sales employee updates lead status/work note.
- Reports show sales task records.

Status:
- Real with duplicate assignment flows.

### Team Head / IT-Marketing Delivery

What it is for:
- Assign converted leads to delivery users: team leaders or marketing managers.

Located:
- `SalesManageController@headTaskassing`
- `SalesManageController@asingtaskdepart`
- `resources/views/admin/leads/completedtask.blade.php`
- `resources/views/admin/taskList/taskbyhead.blade.php`
- `TeamHeadTask`

Routes:
- `headTaskassing`
- `asingtaskdepart`
- `teamhead.task`
- `marketing.employee.task`

Fields:
- lead_id[], user_id, due_date, description, created_by, priority

Status values:
- pending, completed, ongoing, testing, live

Status:
- Partially real; assignment exists, status update workflow is less clear.

### Marketing Manager

What it is for:
- Marketing manager team/task/project/lead/report management.

Located:
- `MarketingEmployeeController`
- `MarketingProjectController`
- `MarketingManagerRoute.php`

Implemented:
- Team members by Marketing Department.
- Shared employee task page.
- Shared leads page.
- Shared project CRUD.
- Marketing drag task.
- Marketing report.

Partial:
- `MarketingProjectController` references `marketing.projects.*` views not present in the inspected Blade tree.

Status:
- Partially implemented through shared modules.

### Reports

What it is for:
- Report views for assigned project work, weekly tasks and sales work.

Located:
- `resources/views/admin/reports/report.blade.php`
- `resources/views/admin/reports/weekly.blade.php`
- `resources/views/admin/tasks/reports.blade.php`
- `resources/views/admin/leads/salestaskreport.blade.php`

Routes:
- `report`
- `week.report`
- `teamhead.report`
- `marketing.report`
- `reportforsales`
- `sales.reportforsales`
- `admin.user.report`

Actions:
- View details.
- Chat/send alert message.
- Pagination.

Status:
- Real but fragmented across multiple task systems.

### Chat / Notifications

What it is for:
- Basic project discussion messages.

Located:
- `ChatManagementController`
- `Discuss`
- Chat boxes in report/task pages

Routes:
- `admin.chat.sms`
- `get.admin.chat`
- `employee.chat.sms`
- `get.employee.chat`

Data:
- employee_id, project_id, chatCount, textSMS

Status:
- Basic real chat. No full notification center.

### Daily Work Logs

What it is for:
- Legacy daily project/module work logs.

Located:
- `ManegemantController`
- `resources/views/admin/daily_work/index.blade.php`
- `resources/views/admin/daily_work/edit.blade.php`
- `ProjectLog`

Routes:
- `daily.work`
- `daily.work.store`
- `daily.work.edit`
- `daily.work.update`

Fields:
- project_id, module_id, work_date, description, hours_spent, status

Status:
- Real but not currently visible in sidebar.

### APIs

What it is for:
- Basic external/API access for users and legacy tasks.

Located:
- `routes/api.php`
- `Api/UserController`
- `Api/TaskController`

Routes:
- POST `/api/login`
- POST `/api/users`
- Sanctum authenticated: logout, profile, users CRUD, task CRUD

Status:
- Basic real API.

## Existing Features

- Multi-role login and role-based redirects.
- Role-based sidebar/menu.
- Employee CRUD with documents and email notification.
- Project CRUD with client/human/infra/module/status/priority/timeline data.
- Project-to-task queue creation.
- Drag/drop assignment to employees.
- Employee/team/marketing task cards with progress/status update.
- Attendance clock-in/lunch/end-work/today-work.
- Leave apply/approve/reject/delete/view.
- Admin/HR/team attendance lists and export.
- Local lead CRUD.
- External lead listing from Fillip Technologies APIs.
- Sales lead task assignment, sales employee update, sales reports.
- Converted lead assignment to team head/marketing manager.
- Basic project chat/discussion messages.
- Legacy task CRUD with attachments and updates.
- Sanctum API for users/tasks.

## Partially Built Features

- Dashboard analytics: DB counts mixed with random growth and hardcoded activity.
- Project detail page: route exists, view exists, controller does not pass project data.
- Settings/users admin routes: plain text only.
- Leave status method: validates but does not update/respond fully.
- MarketingProjectController and marketing-specific project views: code exists but active routes mostly use Admin ProjectController.
- AccountAccess model/table: migration exists, model table name is empty.
- Reports: multiple report systems exist but not unified.
- Notifications: bell/chat exists, no complete notification center.
- Password reset/forgot: UI has concept historically, route not visible in registered list.

## UI-Only / Mock Features

- Dashboard recent activity timeline.
- Dashboard growth percentages generated by `rand()`.
- Some dashboard links with `href="#"`.
- Sales manager sidebar `Leads` link has empty href.
- Admin `users` and `settings` routes return static strings.
- Some filters/buttons may be visual only depending on page.
- Some commented dropdown/sidebar blocks remain.

## Missing Features

- Formal permission matrix beyond role guard checks.
- Central audit/activity log despite mock activity UI.
- Global notification center.
- Unified project/task workflow.
- Complete settings module.
- Robust password reset flow in route list.
- Consistent status vocabulary across projects/leads/tasks.
- Strong null-safety for related records across all views.
- Dedicated CRUD UI for roles table.
- Dedicated CRUD for modules table separate from project JSON modules.
- Complete account access management UI despite model/migration.

## Duplicate / Overlapping Features

- Task systems: `tasks`, `add_tasks` + `assing_tasks`, `taskfor_sales`, `team_head_tasks`, `marketing_projects` + `markering_asing_tasks`.
- Project modules: `projects.modules` JSON and `modules` table.
- Reports: assigned task reports, weekly task reports, legacy task details, sales reports.
- Leads: external Fillip leads, local `lead_creates`, client leads pages, account manager pages.

## Important Existing Data We Must Not Lose

- Users and role/status/department/password hashes.
- Employee documents: profile, adhar_card, pan_card, 10th_certificate, 12th_certificate, graduation.
- Projects and related infra/human resource records.
- Project modules stored in `projects.modules`.
- AddTask and AssingTask assignment history.
- AttendanceInfo time records and today_works.
- TakeLeave records and statuses.
- LeadCreate local CRM data.
- TaskforSales assignments and work notes.
- TeamHeadTask assignments.
- Discuss chat messages.
- Legacy Tasks, TaskUpdates, attachments, performances, reports.
- Sessions/personal access tokens if API/mobile usage is active.

## Reusable Components

- Layout: `resources/views/admin/include/layout.blade.php`
- Sidebar: `resources/views/admin/include/sidebar.blade.php`
- Topnav: `resources/views/admin/include/topnav.blade.php`
- Datatable include: `resources/views/admin/include/datatable.blade.php`
- Error include: `resources/views/admin/include/error.blade.php`
- Change password: `resources/views/admin/include/change_password.blade.php`
- Profile views: `resources/views/profiles/*`
- Email templates: `resources/views/Emails/*`
- Auth helpers: `app/Helpers/AuthCheckHelper.php`
- Universal helpers: `app/Helpers/UniversalHelper.php`

## Existing Workflows

1. Login workflow: user logs in; controller tries guards; role/status checked; user redirects to role dashboard.
2. Employee onboarding: admin creates user with role/department/documents/password; registration email is sent.
3. Project workflow: admin/marketing/project manager creates project; infra/human resources are created; AddTask row is created automatically.
4. Assignment workflow: manager assigns AddTask to employee; AssingTask row is created; mail is sent.
5. Employee task workflow: employee opens assigned task card; updates project progress/status.
6. Attendance workflow: employee starts work, starts/ends lunch, ends work; system calculates total hours; today work can be saved.
7. Leave workflow: employee applies; admin/HR views; admin/HR approves/rejects/deletes; mail on apply/approve.
8. CRM workflow: account manager views external leads, creates/updates/deletes local leads and lead statuses.
9. Sales workflow: account manager assigns lead to sales manager; sales manager assigns/works; sales employee updates lead status/work note.
10. Converted lead delivery workflow: account manager assigns converted leads to team leader/marketing manager.
11. Report/chat workflow: reports show assigned project tasks; chat stores messages in `discusses`.

## What This ERP Already Is

1. A multi-role Laravel ERP using one `users` table and multiple session guards.
2. A project management system with project CRUD, infra details, human resource allocation, modules, and project status/priority.
3. A task assignment system where projects become assignable tasks and managers assign them to employees/team members.
4. An employee operations tool with attendance, work timers, lunch tracking, daily work notes, and leave requests.
5. A CRM/sales workflow with external lead imports, local lead creation, lead status tracking, sales assignment, and sales reports.
6. A delivery workflow where converted leads can be assigned to team leaders or marketing managers.
7. A reporting layer across project assignments, weekly tasks, legacy tasks, and sales lead tasks.
8. A basic project/employee chat-discussion system attached to reports/tasks.
9. A mixed-maturity application: several modules are DB-backed and working, while dashboard analytics, settings, some routes, and some detail pages are placeholder or partial.
10. A codebase with duplicated task/report concepts that should be understood carefully before any redesign or architecture replacement.
