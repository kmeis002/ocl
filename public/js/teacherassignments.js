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
/******/ 	return __webpack_require__(__webpack_require__.s = 5);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/teacherassignments.js":
/*!********************************************!*\
  !*** ./resources/js/teacherassignments.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).on('click', '.edit-assignment', function () {
  var id = $(this).data('id');
  var type = $(this).data('prefix').toLowerCase();
  makeForm(type, id);
  $.get('/api/teacher/get/all/' + type, function (data) {
    populateForm(data, type, id);
  });
});
$(document).on('click', '#edit-assignment', function () {
  var id = $(this).data('id');
  var inputs = $('#edit-container').find(':input');
  var postData = {};

  for (i = 0; i < inputs.length - 2; i++) {
    var tmpField = $(inputs[i]).attr('id');
    var tmpVal = $(inputs[i]).val();
    postData[tmpField] = tmpVal;
  }

  $.post('/api/teacher/update/assignment/' + id, postData, function (data) {}).fail(function (data) {});
});
$(document).on('click', '#delete-assignment', function () {
  var id = $(this).data('id');
  $.post('/api/teacher/delete/assignment/' + id, function (data) {
    location.reload();
  });
});

function makeForm(type, id) {
  $('#edit-container').empty();
  html = '<form>\n<label for="model-select">Assign Resource</label> \
		<select class="form-control" name="model-select" id="edit-model-select"></select>\n';

  if (type == 'b2r') {
    html = html + '<label for="flag-select" class="my-2">Flags Required</label>\n \
		<select class="form-control" name="flag-select" id="flag-select">\n \
			<option value="both">User and Root</option>\n \
			<option value="root">Root Only</option>\n \
			<option value="user">User Only</option>\n \
		</select>\n';
  } else if (type == 'lab') {
    html = html + '<div class="container d-flex justify-content-between my-3">\n \
						<label for="start-flag">Starting Flag</label>\n \
						<input type="number" class="form-control mx-3" name="start-flag" id="start-flag">\n \
						<label for="end-flag">Ending Flag</label>\n \
						<input type="number" class="form-control mx-3" name="end-flag" id="end-flag">\n \
					</div>';
  }

  html = html + '<button type="button" class="btn btn-primary my-2" id="edit-assignment" data-id="' + id + '"><i class="fas fa-save"></i></button>\n \
	 			 <button type="button" class="btn btn-primary my-2" id="delete-assignment" data-id="' + id + '"><i class="fas fa-trash-alt"></i></button>\n \
		</form>';
  $('#edit-container').append(html);
}

function populateForm(data, type, id) {
  for (i = 0; i < data.length; i++) {
    $('#edit-model-select').append('<option value="' + data[i] + '">' + data[i] + '</option>');
  }

  $.get('/api/teacher/get/assignment/modelname/' + id, function (data) {
    $('#edit-model-select').val(data['name']);
  });

  if (type == "lab") {
    $.get('/api/teacher/get/assignment/levels/' + id, function (data) {
      $('#start-flag').val(data['start']);
      $('#end-flag').val(data['end']);
    });
  }
}

/***/ }),

/***/ 5:
/*!**************************************************!*\
  !*** multi ./resources/js/teacherassignments.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/devel/ocl/resources/js/teacherassignments.js */"./resources/js/teacherassignments.js");


/***/ })

/******/ });