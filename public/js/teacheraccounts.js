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
/******/ 	return __webpack_require__(__webpack_require__.s = 7);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/teacher/teacheraccounts.js":
/*!*************************************************!*\
  !*** ./resources/js/teacher/teacheraccounts.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).on('click', '.edit-student', function (event) {
  var id = $(this).data('id');
  $.ajax({
    url: '/teacher/accounts/edit/student/' + id,
    type: 'get',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function success(data) {
      populateTeacherForm(data);
    },
    error: function error(data) {
      console.log(data);
    }
  });
});
$(document).on('click', '.edit-teacher', function (event) {
  var id = $(this).data('id');
  $.ajax({
    url: '/teacher/accounts/edit/teacher/' + id,
    type: 'get',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function success(data) {
      populateTeacherForm(data);
    },
    error: function error(data) {
      console.log(data);
    }
  });
});
$(document).on('click', '.delete-student', function () {
  var id = $(this).data('id');
  $.ajax({
    url: '/teacher/accounts/delete/student/' + id,
    type: 'post',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function success(data) {
      location.reload();
    },
    error: function error(data) {
      console.log(data);
    }
  });
});
$(document).on('click', '.delete-teacher', function () {
  var id = $(this).data('id');
  $.ajax({
    url: '/teacher/accounts/delete/teacher/' + id,
    type: 'post',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function success(data) {
      location.reload();
    },
    error: function error(data) {
      console.log(data);
    }
  });
});
$(document).on('click', '#add-new-student', function () {
  var action = '/teacher/accounts/create/student';
  $('#modify-student').attr('action', action);
  $('#name').show();
  $('#student-name').text('');
  $('#first').val('');
  $('#last').val('');
});
$(document).on('click', '#add-new-teacher', function () {
  var action = '/teacher/accounts/create/teacher';
  $('#modify-teacher').attr('action', action);
  $('#name').show();
  $('#teacher-name').text('');
  $('#first').val('');
  $('#last').val('');
});
$(document).on('click', '#api-reveal', function () {
  $('#api-token').attr('type', 'text');
});
$(document).on('click', '#api-regen', function () {
  var id = $(this).data('id');
  console.log(id);
  $.ajax({
    url: '/teacher/accounts/teacher/api_regen/' + id,
    type: 'post',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function success(data) {
      location.reload();
    },
    error: function error(data) {
      console.log(data);
    }
  });
});

function populateStudentForm(student) {
  $('#student-name').text(student['name']);
  $('#first').val(student['first']);
  $('#last').val(student['last']);
  $('#name').hide();
  var action = '/teacher/accounts/edit/student/' + student['id'];
  $('#modify-student').attr('action', action);
}

function populateTeacherForm(teacher) {
  $('#api-regen').data('id', teacher['id']);
  $('#api-token').attr('type', 'password');
  $('#api-token').attr('type', 'password');
  $('#teacher-name').text(teacher['name']);
  $('#email').val(teacher['email']);
  $('#api-token').val(teacher['api_token']);
  $('#name').hide();
  var action = '/teacher/accounts/edit/teacher/' + teacher['id'];
  $('#modify-teacher').attr('action', action);
}

/***/ }),

/***/ 7:
/*!*******************************************************!*\
  !*** multi ./resources/js/teacher/teacheraccounts.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/devel/ocl/resources/js/teacher/teacheraccounts.js */"./resources/js/teacher/teacheraccounts.js");


/***/ })

/******/ });