import AcademicDashboardController from './AcademicDashboardController'
import GradeController from './GradeController'
import CourseController from './CourseController'
import SubjectController from './SubjectController'
import StudentController from './StudentController'
import TeacherController from './TeacherController'
import ParentController from './ParentController'
import Teams from './Teams'
import Settings from './Settings'

const Controllers = {
    AcademicDashboardController: Object.assign(AcademicDashboardController, AcademicDashboardController),
    GradeController: Object.assign(GradeController, GradeController),
    CourseController: Object.assign(CourseController, CourseController),
    SubjectController: Object.assign(SubjectController, SubjectController),
    StudentController: Object.assign(StudentController, StudentController),
    TeacherController: Object.assign(TeacherController, TeacherController),
    ParentController: Object.assign(ParentController, ParentController),
    Teams: Object.assign(Teams, Teams),
    Settings: Object.assign(Settings, Settings),
}

export default Controllers