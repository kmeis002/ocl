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

/***/ "./resources/js/teacher/teacherreferences.js":
/*!***************************************************!*\
  !*** ./resources/js/teacher/teacherreferences.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  $('#section-content').summernote();
});
$(document).on('click', '.edit-ref', function (event) {
  var id = $(this).data('id');
  $('#edit-id').text(id);
  $('#edit-name').text($(this).data('name'));
  $('#add-new-skill').attr('data-ref', id);
  updateSectionList(id);
  updateSkillList(id);
});
$(document).on('click', '#new-section', function (event) {
  $('#section-name').val('');
  $('#section-content').summernote('code', '');
  $('#section-id').attr('value', '');
});
$(document).on('click', '#add-new-skill', function () {
  var skill = $('#skill-select').val();
  var refId = $('#edit-id').text();

  if (refId != '') {
    $.ajax({
      url: '/teacher/create/reference/skill/' + refId,
      type: 'post',
      data: {
        skill: skill
      },
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function success(data) {
        updateSkillList(refId);
      },
      error: function error(data) {
        console.log(data);
      }
    });
  }
});
$(document).on('click', '.delete-skill', function () {
  var skill = $(this).data('name');
  var refId = $('#edit-id').text();
  $.ajax({
    url: '/teacher/delete/reference/skills/' + refId,
    type: 'post',
    data: {
      skill: skill
    },
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function success(data) {
      updateSkillList(refId);
    },
    error: function error(data) {
      console.log(data);
    }
  });
});
$(document).on('change', '#section-select', function () {
  var id = $(this).val();
  updateSection(id);
});
$(document).on('click', '#save-section', function () {
  var ref_id = $('#edit-id').text();
  var name = $('#section-name').val();
  var content = $('#section-content').val();

  if ($('#section-id').attr('value') == '') {
    $.ajax({
      url: '/teacher/create/section/' + ref_id,
      type: 'post',
      data: {
        name: name,
        content: content
      },
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function success(data) {
        updateSectionList(ref_id);
      },
      error: function error(data) {
        console.log(data);
      }
    });
  } else {
    var id = $('#section-id').attr('value');
    $.ajax({
      url: '/teacher/update/section/' + id,
      type: 'post',
      data: {
        name: name,
        content: content
      },
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function success(data) {
        updateSectionList(ref_id);
      },
      error: function error(data) {
        console.log(data);
      }
    });
  }
});
$(document).on('click', '#delete-section', function (event) {
  var id = $('#section-id').attr('value');

  if (id != '') {
    var ref_id = $('#edit-id').text();
    $.ajax({
      url: '/teacher/delete/section/' + id,
      type: 'post',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function success(data) {
        updateSectionList(ref_id);
        $('#section-name').val('');
        $('#section-content').summernote('code', '');
        $('#section-id').attr('value', '');
      },
      error: function error(data) {
        console.log(data);
      }
    });
  }
});
$(document).on('click', '.delete-ref', function () {
  var id = $(this).data('id');
  $.ajax({
    url: '/teacher/delete/reference/' + id,
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
$(document).on('click', '#add-new-ref', function () {
  var name = $('#new-ref-name').val();
  console.log(name);
  $.ajax({
    url: '/teacher/create/reference',
    type: 'post',
    data: {
      name: name
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

function updateSectionList(id) {
  $.ajax({
    url: '/teacher/get/sections/name/' + id,
    type: 'get',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function success(data) {
      populateSectionList(data);
    },
    error: function error(data) {
      console.log(data);
    }
  });
}

function populateSectionList(data) {
  $('#section-select option:gt(0)').remove();

  for (i = 0; i < data.length; i++) {
    html = '<option value="' + data[i]['id'] + '">Section ' + (i + 1) + ': ' + data[i]['name'] + '</option>';
    $('#section-select').append(html);
  }
}

function updateSection(id) {
  $.ajax({
    url: '/teacher/get/section/' + id,
    type: 'get',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function success(data) {
      $('#section-name').val(data['name']);
      $('#section-content').summernote('code', data.content);
      $('#section-id').attr('value', data.id);
    },
    error: function error(data) {
      console.log(data);
    }
  });
}

function updateSkillList(id) {
  $.ajax({
    url: '/teacher/get/reference/skills/' + id,
    type: 'get',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function success(data) {
      $("#skills-table tr").not(':last').not(':first').remove();

      for (i = 0; i < data.length; i++) {
        html = '<tr>\n<td>' + data[i]['skill_name'] + '</td>\n<td><button type="button" class="btn btn-primary delete-skill" data-name="' + data[i]['skill_name'] + '"><i class="fas fa-trash-alt"></i></button></td>\n</tr>';
        $('#skills-list').prepend(html);
      }
    },
    error: function error(data) {
      console.log(data);
    }
  });
}

/***/ }),

/***/ 9:
/*!*********************************************************!*\
  !*** multi ./resources/js/teacher/teacherreferences.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/ocl/resources/js/teacher/teacherreferences.js */"./resources/js/teacher/teacherreferences.js");


/***/ })

/******/ });