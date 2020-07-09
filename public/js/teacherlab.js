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
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/teacherlab.js":
/*!************************************!*\
  !*** ./resources/js/teacherlab.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  $('.edit-lab').click(function () {
    window.getModelInfo($('#type-header').data('model-type'), $(this).data('name'));
  }); //collapse level flags

  $('#collapse-flags').click(function () {
    if ($('#collapse-flags-icon').attr('class').includes('compress')) {
      $('#level-flags').hide();
      $('#collapse-flags-icon').attr('class', 'fas fa-expand-arrows-alt');
    } else {
      $('#level-flags').show();
      $('#collapse-flags-icon').attr('class', 'fas fa-compress-arrows-alt');
    }
  }); //collapse skills
  //add new level, api creates random flag to be updated by user

  $('#new-lab-level').click(function () {
    name = $('#edit-vm-name').text();

    if (name == '') {
      alert('Please select a machine before adding a level');
    } else {
      $.post('/api/teacher/create/lab/' + name + '/level', function () {
        window.getModelInfo($('#type-header').data('model-type'), name);
      });
    }
  }); //manual flags for creating VM Modal

  $('#manual-flags').change(function () {
    if ($(this).val() == "Manual") {
      $('#flags').show();
    } else {
      $('#flags').hide();
    }
  });
  $('#level-count').keyup(function (event) {
    makeLevelFlagItem($(this).val());
  }); //Remove lab levels

  $(document).on('click', '.delete-level', function (event) {
    id = $(this).data('id');
    name = $('#edit-vm-name').text();
    $.post('/api/teacher/delete/lab/' + name + '/level/' + id, function () {
      window.getModelInfo($('#type-header').data('model-type'), name);
    });
  });

  function makeLevelFlagItem(levels) {
    $('#flags').empty();

    for (i = 1; i <= levels; i++) {
      var tmpId = 'level-flag-' + i;
      var line = '<label for="' + tmpId + '">Level #' + i + ' Flag</label>\n';
      line = line + '<input type="text" id="' + tmpId + '" name="' + tmpId + '" class="form-control">\n';
      $('#flags').append(line);
    }
  } //collapse flags for labs 

});

/***/ }),

/***/ 3:
/*!******************************************!*\
  !*** multi ./resources/js/teacherlab.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/devel/ocl/resources/js/teacherlab.js */"./resources/js/teacherlab.js");


/***/ })

/******/ });