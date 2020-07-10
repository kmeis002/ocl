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

/***/ "./resources/js/teacheredithints.js":
/*!******************************************!*\
  !*** ./resources/js/teacheredithints.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  $('.edit-hints-modal').click(function (event) {
    $('#edit-hints-table').empty();
    $('#editHintsModal').modal('show');
    var name = $(this).data('name');
    var type = $('#type-header').data('model-type');
    var baseAction = $('#edit-hints').attr('action');
    $('#edit-hints').attr('data-name', name);
    $('#edit-hints').attr('action', baseAction + name);
    $('#editHintsModal').attr('data-name', name);
    window.getModelInfo(type + '/hints', name);
  });
  $('.close-new-hint').click(function () {
    $('#new-level').empty();
    $('#newHintModal').modal('hide');
  }); //update hints api call

  $('#update-hints').click(function (event) {
    var hints = [];
    var count = 0;
    var name = $('#edit-hints').data('name');
    var type = $('#edit-hints').data('type');
    $('#edit-hints-table tr').each(function () {
      var idContent = $(this).find('[id*="hint-id-"]').val();
      var hintContent = $(this).find('td [id*="hint-content-"]').val();

      if (type == 'b2r') {
        var isRoot = $(this).find('td [id*="is-root"]').prop('checked');
        hints.push({
          'id': idContent,
          'hint': hintContent,
          'is_root': isRoot
        });
      } else if (type == 'lab') {
        var level = $(this).find('td [id*="level-"]').val();
        hints.push({
          'id': idContent,
          'hint': hintContent,
          'level': level
        });
      }
    });
    url = '/api/teacher/update/' + type + '/' + name + '/hints';
    $.ajax({
      type: "POST",
      url: url,
      data: JSON.stringify(hints),
      dataType: "json",
      contentType: "application/json",
      processData: "false",
      success: function success(data) {
        $('#edit-hints-table').empty();
        name = $('#edit-hints').data('name');
        window.getModelInfo(type + '/hints', name);
      }
    });
  }); //create new hint

  $('#create-hint').click(function () {
    var type = $('#edit-hints').data('type');
    var name = $('#edit-hints').data('name');
    var url = '/api/teacher/create/' + type + '/' + name + '/hints';
    var hintContent = $('#new-hint').val();

    if ($('#is-root').length) {
      var isRoot = $('#is-root').prop('checked');
      $.post(url, {
        hint: hintContent,
        is_root: isRoot
      }, function (data) {
        $('#new-hint').val('');
        $('#newHintModal').modal('hide');
        $('#edit-hints-table').empty();
        name = $('#edit-hints').data('name');
        window.getModelInfo(type + '/hints', name);
      });
    } else if ($('#new-level').length) {
      var level = $('#new-level').val();
      $.post(url, {
        hint: hintContent,
        level: level
      }, function (data) {
        $('#new-hint').val('');
        $('#newHintModal').modal('hide');
        $('#edit-hints-table').empty();
        name = $('#edit-hints').data('name');
        window.getModelInfo(type + '/hints', name, $('#hint-page-nav').attr('data-current'));
      });
    }
  });
  $('#newHintModal').on('show.bs.modal', function (event) {
    window.labHintOptions($('#add-new-hint-form').attr('data-levels'));
  }); //remove hint

  $(document).on('click', '.remove-hint', function (event) {
    //Process button click event
    id = this.id.substring(12);
    type = $('#edit-hints').data('type');
    url = '/api/teacher/delete/' + type + '/hints/' + id;
    name = $(this).data('name'); //post to hints CRUD api then refresh modal

    $.post(url, function (data) {
      $('#edit-hints-table').empty();

      if ($('#hint-page-nav').length) {
        window.getModelInfo(type + '/hints', name, $('#hint-page-nav').attr('data-current'));
      } else {
        window.getModelInfo(type + '/hints', name);
      }
    });
  }); //hint pagination

  $(document).on('click', '.hint-page-link', function (event) {
    var page = $(this).text();
    var name = $('#edit-hints').data('name');
    var type = $('#type-header').data('model-type');
    window.getModelInfo(type + '/hints', name, page);
  });
});

window.makeHintRow = function (item, index, type, levels) {
  rowId = 'hint-row-' + index;
  hintIdLabel = 'hint-id-' + item['id'];
  hintLabel = 'hint-content-' + item['id'];
  isRootLabel = 'is-root-' + item['id'];
  levelLabel = 'level-' + item['id'];
  buttonLabel = 'remove-hint-' + item['id'];
  out = '<tr id="' + rowId + '">\n<input type="hidden" class="form-control" id="' + hintIdLabel + '" value="' + item['id'] + '" name="hint-id-' + index + '">\n';
  out = out + '<td><input type="text" class="form-control" name="' + hintLabel + '"id="' + hintLabel + '"></td>\n';

  if (type == 'b2r') {
    out = out + '<td><input type="checkbox" class="form-control" name="' + isRootLabel + '" id="' + isRootLabel + '"></td>\n';
  } else if (type == 'lab') {
    out = out + '<td><select type="os-select" class="form-control" name="level" id="' + levelLabel + '">\n';

    for (i = 1; i <= levels; i++) {
      out = out + '<option value="' + i + '">' + i + '</option>\n';
    }

    out = out + '</select></td>\n';
  }

  out = out + '<td><button type="button" class="btn btn-primary remove-hint" id="' + buttonLabel + '" name="' + buttonLabel + '" data-name="' + item[type + '_name'] + '"><i class="fas fa-trash-alt"></i></button\n</tr>\n';
  $('#edit-hints-table').append(out);
};

window.labHintOptions = function (levels) {
  $('#new-level').empty();
  options = '';

  for (i = 1; i <= levels; i++) {
    options = options + '<option value="' + i + '">' + i + '</option>\n';
  }

  $('#new-level').append(options);
};

window.populateHintRow = function (item, type, index) {
  hintIdLabel = 'hint-id-' + item['id'];
  hintLabel = 'hint-content-' + item['id'];
  isRootLabel = 'is-root-' + item['id'];
  levelLabel = 'level-' + item['id'];
  buttonLabel = 'remove-hint-' + index;
  $('#' + hintIdLabel).val(item['id']);
  $('#' + hintLabel).val(item['hint']);

  if (type == 'b2r') {
    $('#' + isRootLabel).attr('checked', item['is_root'] == 1);
  } else if (type == 'lab') {
    $('#' + levelLabel).val(item['level']);
  }
};

window.makePagination = function (pages) {
  $('#hint-pagination').empty();
  p = '';

  for (i = 1; i <= pages; i++) {
    p = p + '<li class="page-item" id="hint-page-' + i + '"><button type="button" class="btn btn-primary-trans btn-sm page-link hint-page-link">' + i + '</button></li>';
  }

  $('#hint-pagination').append(p);
};

/***/ }),

/***/ 5:
/*!************************************************!*\
  !*** multi ./resources/js/teacheredithints.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/devel/ocl/resources/js/teacheredithints.js */"./resources/js/teacheredithints.js");


/***/ })

/******/ });