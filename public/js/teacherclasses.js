/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/teacherclasses.js":
/*!****************************************!*\
  !*** ./resources/js/teacherclasses.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ./teachercourses */ "./resources/js/teachercourses.js");

/***/ }),

/***/ "./resources/js/teachercourses.js":
/*!****************************************!*\
  !*** ./resources/js/teachercourses.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

//------------------COURSE JQUERY---------------------//
$(document).on('click', '#add-new-course', function () {
  var courseName = $('#new-course-name').val();
  $.post('/api/teacher/create/course', {
    name: courseName
  }, function (data) {
    location.reload();
  });
});
$(document).on('click', '.delete-course', function () {
  var id = $(this).data('id');
  var courseName = $('#course-' + id).text();
  $.post('/api/teacher/delete/course/' + courseName, {
    name: courseName
  }, function (data) {
    location.reload();
  });
}); //------------------CLASS JQUERY---------------------//

$(document).on('click', '#add-new-class', function () {
  var courseName = $('#new-class-course').val();
  var teacherName = $('#new-class-teacher').val();
  var bell = $('#new-class-bell').val();
  $.post('/api/teacher/create/class', {
    course: courseName,
    teacher: teacherName,
    bell: bell
  }, function (data) {
    location.reload();
  });
});
$(document).on('click', '.delete-class', function () {
  var id = $(this).data('id');
  $.post('/api/teacher/delete/class/' + id, function (data) {
    location.reload();
  });
}); //------------------SELECT JQUERY---------------------//

$(document).ready(function () {
  $.get('/api/teacher/get/courses', function (data) {
    makeCourseList(data);
  });
});
$(document).ready(function () {
  $.get('/api/teacher/get/teachers', function (data) {
    makeTeacherList(data);
  });
});

function makeCourseList(courses) {
  $('#new-class-course').empty();

  for (i = 0; i < courses.length; i++) {
    html = '<option value = "' + courses[i]['name'] + '">' + courses[i]['name'] + '</option>\n';
    $('#new-class-course').append(html);
  }
}

function makeTeacherList(teachers) {
  $('#new-class-teacher').empty();

  for (i = 0; i < teachers.length; i++) {
    html = '<option value = "' + teachers[i] + '">' + teachers[i] + '</option>\n';
    $('#new-class-teacher').append(html);
  }
}

/***/ }),

/***/ 2:
/*!**********************************************!*\
  !*** multi ./resources/js/teacherclasses.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/devel/ocl/resources/js/teacherclasses.js */"./resources/js/teacherclasses.js");


/***/ })

/******/ });