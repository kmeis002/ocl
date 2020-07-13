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

/***/ "./resources/js/student/studentlabs.js":
/*!*********************************************!*\
  !*** ./resources/js/student/studentlabs.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).on('click', '#hint-reveal', function () {
  var name = $('#vm-name').text();
  $.ajax({
    url: '/student/get/hint/lab/' + name,
    type: 'post',
    data: {
      hint: $('#hint-reveal').data('hint-id')
    },
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function success(data) {
      console.log(data);
      $('#ajax-alert').text('Hint!\n ' + data['hint']);
      $('#hintModal').modal('hide');
    },
    error: function error(data) {
      console.log(data);
    }
  });
});
$(document).on('show.bs.modal', '#flagModal', function (event) {
  var button = $(event.relatedTarget);
  var flagId = button.data('level'); //set submit data

  $('#submit-flag').data('flag-id', flagId);
});
$(document).on('click', '#submit-flag', function () {
  var name = $('#vm-name').text();
  var flagId = $('#submit-flag').data('flag-id');
  var flag = $('#flag').val();
  var type = $('#submit-flag').data('type');
  $.ajax({
    url: '/student/submit/flag/' + name,
    type: 'post',
    data: {
      flag: flag,
      flagId: flagId,
      type: type
    },
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function success(data) {//refresh data
    },
    error: function error(data) {}
  });
});
$(document).ready(function () {
  $('#hintModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var msg = button.data('msg');
    var modal = $(this);
    modal.find('.modal-body').text(msg);
    $('#hint-num').val(button.data('hintnum'));
    $('#is-root').val(button.data('isroot'));
    $('#hint-reveal').data('hint-id', button.data('hint-id'));
  });
  $('#flagModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var title = button.data('title');
    var modal = $(this);
    modal.find('.modal-header').text(title);
  });
});
$(document).on('click', '.update-model-view', function () {
  var name = $(this).data('name');
  $.get('/student/get/lab/' + name, function (data) {
    updateMachineInfo(data['machine']);
    populateLevels(data['levels']);
    populateHints(data['hints']);
  });
});

function updateMachineInfo(machineInfo) {
  var iconClasses = 'fa-7x ';
  $('#vm-icon').attr('class', iconClasses + machineInfo['icon']);
  $('#vm-name').text(machineInfo['name']);
  $('#vm-os').text(machineInfo['os']);
  $('#vm-points').text(machineInfo['points']);
  $('#vm-ip').text(machineInfo['ip']);
  var skills = machineInfo['skills'];
  skillHtml = '';

  for (i = 0; i < skills.length; i++) {
    skillHtml = skillHtml + skills[i]['skill'];

    if (i < skills.length - 1) {
      skillHtml = skillHtml + ' - ';
    }
  }

  $('#vm-skills').text(skillHtml);
  var classes = 'fas fa-power-off fa-2x my-auto mx-2';

  if (machineInfo['status']) {
    $('#vm-status-icon').attr('class', classes + ' text-primary');
  } else {
    $('#vm-status-icon').attr('class', classes + ' text-danger');
  }

  $('#vm-description').text(machineInfo['description']);
}

function populateLevels(levels) {
  $('#lab-table-body').empty();

  for (i = 1; i <= levels; i++) {
    html = '<tr>\n\
	            <td scope="row">' + i + '</td>\n\
	                <td>\n\
	                    <div class="btn-group btn-group-sm" id="level-hints-' + i + '" role="group" aria-label="Basic example">\n\
	                    </div>\n\
	                </td>\n\
	            	<td><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#flagModal" data-level="' + i + '"><i class="fas fa-plus"></i></button></td>\n\
	        </tr>\n';
    $('#lab-table-body').append(html);
  }
}

function populateHints(hints) {
  var count = 1;

  for (i = 0; i < hints.length; i++) {
    html = '<button type="button" class="btn btn-primary my-2" \
		id="user-hint-n" data-toggle="modal" data-target="#hintModal" data-hint-id="' + hints[i]['id'] + '" \
		data-msg="Revealing this hint will reduce your total online score (but not your grade). Do you still want to reveal User Hint #' + count + '" \
		data-isroot="false">Hint #' + count + '</button><br>';
    count++;

    if (i < hints.length - 1 && hints[i]['level'] != hints[i + 1]['level']) {
      count = 1;
    }

    $('#level-hints-' + hints[i]['level']).append(html);
  }
}

/***/ }),

/***/ 7:
/*!***************************************************!*\
  !*** multi ./resources/js/student/studentlabs.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/devel/ocl/resources/js/student/studentlabs.js */"./resources/js/student/studentlabs.js");


/***/ })

/******/ });