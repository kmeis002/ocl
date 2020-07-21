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
/******/ 	return __webpack_require__(__webpack_require__.s = 9);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/teacher/teacherenroll.js":
/*!***********************************************!*\
  !*** ./resources/js/teacher/teacherenroll.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  $.ajax({
    url: '/teacher/get/students',
    type: 'get',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function success(data) {
      populateStudentList(data);
    },
    error: function error(data) {
      console.log(data);
    }
  });
  $.ajax({
    url: '/teacher/get/classes',
    type: 'get',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function success(data) {
      populateClassList(data);
      var classSelect = $('#class-select');
      var id = classSelect.val();
      var bell = classSelect.find('[value="' + id + '"').data('bell');
      var course = classSelect.find('[value="' + id + '"').data('course');
      changeClass(id, bell, course);
      populateEnrolledList(id);
    },
    error: function error(data) {
      console.log(data);
    }
  });
});
$(document).on('change', '#class-select', function (event) {
  var id = $(this).val();
  var bell = $(this).find('[value="' + id + '"').data('bell');
  var course = $(this).find('[value="' + id + '"').data('course');
  changeClass(id, bell, course);
  populateEnrolledList(id);
});
$(document).on('click', '#enroll-student', function () {
  var student = $('#enroll-student-select').val();
  var classId = $('#class-row').attr('data-id');
  $.ajax({
    url: '/teacher/enroll/' + classId,
    type: 'post',
    data: {
      student: student
    },
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function success(data) {
      populateClassList(data);
      console.log(data);
      populateEnrolledList(classId);
    },
    error: function error(data) {
      console.log(data);
    }
  });
});
$(document).on('click', '.unenroll', function (event) {
  var student = $(this).data('name');
  var classId = $('#class-row').attr('data-id');
  $.ajax({
    url: '/teacher/unenroll/' + classId,
    type: 'post',
    data: {
      studentName: student
    },
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function success(data) {
      populateEnrolledList(classId);
    },
    error: function error(data) {
      console.log(data);
    }
  });
});

function populateStudentList(students) {
  $('#enroll-student-select').empty();

  for (i = 0; i < students.length; i++) {
    html = '<option value="' + students[i]['name'] + '">' + students[i]['last'] + ', ' + students[i]['first'] + '</option>\n';
    $('#enroll-student-select').append(html);
  }
}

function populateClassList(classes) {
  $('#class-select').empty();

  for (i = 0; i < classes.length; i++) {
    html = '<option value="' + classes[i]['id'] + '"" data-bell="' + classes[i]['bell'] + '" data-course="' + classes[i]['course'] + '">' + 'Bell: ' + classes[i]['bell'] + ' Course: ' + classes[i]['course'] + '</option>\n';
    $('#class-select').append(html);
  }
}

function changeClass(id, bell, course) {
  $('#class-row').attr("data-id", id);
  $('#class-row-bell').text(bell);
  $('#class-row-course').text(course);
}

function populateEnrolledList(classId) {
  $('#class-row-roster').empty();
  $.ajax({
    url: '/teacher/get/enrolled/' + classId,
    type: 'get',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function success(data) {
      for (i = 0; i < data.length; i++) {
        html = '<p>' + data[i][0]['last'] + ', ' + data[i][0]['first'] + '<button type="button" class="btn btn-primary unenroll mx-2" data-name="' + data[i][0]['name'] + '"><i class="fas fa-trash-alt"></i></button></p>';
        $('#class-row-roster').append(html);
      }
    },
    error: function error(data) {
      console.log(data);
    }
  });
}

/***/ }),

/***/ 9:
/*!*****************************************************!*\
  !*** multi ./resources/js/teacher/teacherenroll.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/devel/ocl/resources/js/teacher/teacherenroll.js */"./resources/js/teacher/teacherenroll.js");


/***/ })

/******/ });