import AcademicDashboardController from './AcademicDashboardController'
import GradeController from './GradeController'
import SubjectController from './SubjectController'
import CourseController from './CourseController'
import StudentController from './StudentController'
import ParentController from './ParentController'
import TeacherController from './TeacherController'
import Teams from './Teams'
import Settings from './Settings'

const Controllers = {
    AcademicDashboardController: Object.assign(AcademicDashboardController, AcademicDashboardController),
    GradeController: Object.assign(GradeController, GradeController),
    SubjectController: Object.assign(SubjectController, SubjectController),
    CourseController: Object.assign(CourseController, CourseController),
    StudentController: Object.assign(StudentController, StudentController),
    ParentController: Object.assign(ParentController, ParentController),
    TeacherController: Object.assign(TeacherController, TeacherController),
    Teams: Object.assign(Teams, Teams),
    Settings: Object.assign(Settings, Settings),
}

export default Controllers