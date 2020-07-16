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
/******/ 	return __webpack_require__(__webpack_require__.s = 10);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/student/studentctflist.js":
/*!************************************************!*\
  !*** ./resources/js/student/studentctflist.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  var radios = $('input[type="radio"]');
  radios.change(function () {
    var catvalue = $('input[name="cat-options"]:checked').val().toLowerCase();
    var ptvalue = $('input[name="pt-options"]:checked').val().toLowerCase();
    var svalue = $('input[name="s-options"]:checked').val().toLowerCase();

    if (catvalue == 'all' || ptvalue == 'all' || svalue == 'all') {
      $("#ctf-list tr").filter(function () {
        $(this).show();
      });
    }

    if (catvalue != 'all') {
      $("#ctf-list tr:visible").filter(function () {
        $(this).toggle($(this).find('.cat').text().toLowerCase().indexOf(catvalue) > -1);
      });
    }

    if (ptvalue != 'all') {
      $("#ctf-list tr:visible").filter(function () {
        $(this).toggle(parseInt($(this).find('.pts').text()) <= parseInt(ptvalue) && parseInt($(this).find('.pts').text()) > parseInt(ptvalue) - 10);
      });
    }

    if (svalue != 'all') {
      $("#ctf-list tr:visible").filter(function () {
        $(this).toggle($(this).find('.assigned').text().toLowerCase().indexOf(svalue) > -1);
      });
    }
  });
  $("#name-search").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $("#ctf-list tr").filter(function () {
      $(this).toggle($(this).find('.ctf-name').text().toLowerCase().indexOf(value) > -1);
    });
  });
  $('#descriptionModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var title = button.data('title');
    var msg = button.data('msg');
    var modal = $(this);
    modal.find('.modal-header').text(title);
    modal.find('.modal-body').text(msg);
  });
  $('#flagModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var title = button.data('title');
    var modal = $(this);
    modal.find('.modal-header').text('Submit ' + title + ' Flag');
  });
});
$(document).on('show.bs.modal', '#flagModal', function (event) {
  var button = $(event.relatedTarget);
  var flagId = button.data('title'); //set submit data

  $('#submit-flag').data('flag-id', flagId);
});
$(document).on('click', '#submit-flag', function () {
  var name = $('#submit-flag').data('flagId');
  var type = $('#submit-flag').data('type');
  var flag = $('#flag').val();
  $.ajax({
    url: '/student/submit/flag/' + name,
    type: 'post',
    data: {
      type: type,
      flag: flag
    },
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

function updateCtfRow() {}

/***/ }),

/***/ 10:
/*!******************************************************!*\
  !*** multi ./resources/js/student/studentctflist.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/devel/ocl/resources/js/student/studentctflist.js */"./resources/js/student/studentctflist.js");


/***/ })

/******/ });