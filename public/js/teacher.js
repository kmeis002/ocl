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
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/chunkupload.js":
/*!*************************************!*\
  !*** ./resources/js/chunkupload.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

//What is required: token, sha256sum of file name, file, filesize, chunksize, total chunks, url (reuse)
window.chunkUpload = /*#__PURE__*/function () {
  function _class(url, chunk_size) {
    _classCallCheck(this, _class);

    this.request_limit = 1000;
    this.url = url; //this.api_token = document.querySelector( '.api_token' ).value;

    this.file = document.querySelector('#ova-file').files[0];
    this.reader = new FileReader();

    if (this.getTotalChunks(chunk_size * 1024) > this.request_limit) {
      this.chunk_size = this.getChunkSize() * 1024;
    } else {
      this.chunk_size = chunk_size * 1024;
    }

    this.curr_chunk = 0;
    this.total_chunks = this.getTotalChunks(this.chunk_size);
    this["final"] = false;
  } //Calculates the chunk size based on file size and api request limit (1000)


  _createClass(_class, [{
    key: "getChunkSize",
    value: function getChunkSize() {
      //console.log("Calculating total chunk size", Math.ceil(this.file.size/(this.request_limit*1024)));
      return Math.ceil(this.file.size / (this.request_limit * 1024));
    }
  }, {
    key: "getTotalChunks",
    value: function getTotalChunks(size) {
      //console.log("Calculating total chunks", Math.ceil(this.file.size/size));
      return Math.ceil(this.file.size / size);
    }
  }, {
    key: "upload_file",
    value: function upload_file(start, obj) {
      var next_slice = start + obj.chunk_size + 1;
      var blob = obj.file.slice(start, next_slice);
      var _final = false;
      var first = false;

      this.reader.onloadend = function (event) {
        if (event.target.readyState !== FileReader.DONE) {
          return;
        }

        if (obj.curr_chunk == obj.total_chunks - 1) {
          _final = true;
        } else if (obj.curr_chunk == 0) {
          first = true;
        }

        $.ajax({
          url: obj.url,
          type: 'POST',
          dataType: 'text',
          cache: false,
          data: {
            //api_token: obj.api_token,
            file_data: event.target.result,
            file: obj.file.name,
            file_type: obj.file.type,
            first_chunk: first,
            final_chunk: _final
          },
          error: function error(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
          },
          success: function success(data) {
            obj.curr_chunk++;
            var percentage = Math.floor(obj.curr_chunk / obj.total_chunks * 100);
            $('[id*="-progress"]').css('width', percentage + '%');

            if (_final) {
              location.reload();
            }

            if (next_slice < obj.file.size) {
              obj.upload_file(next_slice, obj);
            }
          }
        });
      };

      this.reader.readAsDataURL(blob);
    }
  }]);

  return _class;
}();

window.selectorScript = function (url, name) {
  var filePath = $('#ova-file').val().split('\\');
  var fileName = filePath[filePath.length - 1];

  if (fileName == name + '.ova') {
    var p = new window.chunkUpload(url, 10000);
    p.upload_file(0, p);
  } else {
    alert('OVA File must be labeled the same name as the Machine. Please select a file with the name: ' + name + '.ova');
  }
};

/***/ }),

/***/ "./resources/js/createvm.js":
/*!**********************************!*\
  !*** ./resources/js/createvm.js ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {});

/***/ }),

/***/ "./resources/js/editHints.js":
/*!***********************************!*\
  !*** ./resources/js/editHints.js ***!
  \***********************************/
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

/***/ "./resources/js/ovaupload.js":
/*!***********************************!*\
  !*** ./resources/js/ovaupload.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {});

/***/ }),

/***/ "./resources/js/teacher.js":
/*!*********************************!*\
  !*** ./resources/js/teacher.js ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ./chunkupload */ "./resources/js/chunkupload.js");

__webpack_require__(/*! ./teacherforms */ "./resources/js/teacherforms.js");

__webpack_require__(/*! ./editHints */ "./resources/js/editHints.js");

__webpack_require__(/*! ./createvm */ "./resources/js/createvm.js");

__webpack_require__(/*! ./ovaupload */ "./resources/js/ovaupload.js");

__webpack_require__(/*! ./teacherfunctions */ "./resources/js/teacherfunctions.js");

__webpack_require__(/*! ./teacherResources */ "./resources/js/teacherResources.js");

/***/ }),

/***/ "./resources/js/teacherResources.js":
/*!******************************************!*\
  !*** ./resources/js/teacherResources.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {



/***/ }),

/***/ "./resources/js/teacherforms.js":
/*!**************************************!*\
  !*** ./resources/js/teacherforms.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  var icons = [{
    icon: 'fas fa-ad'
  }, {
    icon: 'fas fa-address-book'
  }, {
    icon: 'fas fa-address-card'
  }, {
    icon: 'fas fa-adjust'
  }, {
    icon: 'fas fa-air-freshener'
  }, {
    icon: 'fas fa-align-center'
  }, {
    icon: 'fas fa-align-justify'
  }, {
    icon: 'fas fa-align-left'
  }, {
    icon: 'fas fa-align-right'
  }, {
    icon: 'fas fa-allergies'
  }, {
    icon: 'fas fa-ambulance'
  }, {
    icon: 'fas fa-american-sign-language-interpreting'
  }, {
    icon: 'fas fa-anchor'
  }, {
    icon: 'fas fa-angle-double-down'
  }, {
    icon: 'fas fa-angle-double-left'
  }, {
    icon: 'fas fa-angle-double-right'
  }, {
    icon: 'fas fa-angle-double-up'
  }, {
    icon: 'fas fa-angle-down'
  }, {
    icon: 'fas fa-angle-left'
  }, {
    icon: 'fas fa-angle-right'
  }, {
    icon: 'fas fa-angle-up'
  }, {
    icon: 'fas fa-angry'
  }, {
    icon: 'fas fa-ankh'
  }, {
    icon: 'fas fa-apple-alt'
  }, {
    icon: 'fas fa-archive'
  }, {
    icon: 'fas fa-archway'
  }, {
    icon: 'fas fa-arrow-alt-circle-down'
  }, {
    icon: 'fas fa-arrow-alt-circle-left'
  }, {
    icon: 'fas fa-arrow-alt-circle-right'
  }, {
    icon: 'fas fa-arrow-alt-circle-up'
  }, {
    icon: 'fas fa-arrow-circle-down'
  }, {
    icon: 'fas fa-arrow-circle-left'
  }, {
    icon: 'fas fa-arrow-circle-right'
  }, {
    icon: 'fas fa-arrow-circle-up'
  }, {
    icon: 'fas fa-arrow-down'
  }, {
    icon: 'fas fa-arrow-left'
  }, {
    icon: 'fas fa-arrow-right'
  }, {
    icon: 'fas fa-arrow-up'
  }, {
    icon: 'fas fa-arrows-alt'
  }, {
    icon: 'fas fa-arrows-alt-h'
  }, {
    icon: 'fas fa-arrows-alt-v'
  }, {
    icon: 'fas fa-assistive-listening-systems'
  }, {
    icon: 'fas fa-asterisk'
  }, {
    icon: 'fas fa-at'
  }, {
    icon: 'fas fa-atlas'
  }, {
    icon: 'fas fa-atom'
  }, {
    icon: 'fas fa-audio-description'
  }, {
    icon: 'fas fa-award'
  }, {
    icon: 'fas fa-baby'
  }, {
    icon: 'fas fa-baby-carriage'
  }, {
    icon: 'fas fa-backspace'
  }, {
    icon: 'fas fa-backward'
  }, {
    icon: 'fas fa-bacon'
  }, {
    icon: 'fas fa-bahai'
  }, {
    icon: 'fas fa-balance-scale'
  }, {
    icon: 'fas fa-balance-scale-left'
  }, {
    icon: 'fas fa-balance-scale-right'
  }, {
    icon: 'fas fa-ban'
  }, {
    icon: 'fas fa-band-aid'
  }, {
    icon: 'fas fa-barcode'
  }, {
    icon: 'fas fa-bars'
  }, {
    icon: 'fas fa-baseball-ball'
  }, {
    icon: 'fas fa-basketball-ball'
  }, {
    icon: 'fas fa-bath'
  }, {
    icon: 'fas fa-battery-empty'
  }, {
    icon: 'fas fa-battery-full'
  }, {
    icon: 'fas fa-battery-half'
  }, {
    icon: 'fas fa-battery-quarter'
  }, {
    icon: 'fas fa-battery-three-quarters'
  }, {
    icon: 'fas fa-bed'
  }, {
    icon: 'fas fa-beer'
  }, {
    icon: 'fas fa-bell'
  }, {
    icon: 'fas fa-bell-slash'
  }, {
    icon: 'fas fa-bezier-curve'
  }, {
    icon: 'fas fa-bible'
  }, {
    icon: 'fas fa-bicycle'
  }, {
    icon: 'fas fa-biking'
  }, {
    icon: 'fas fa-binoculars'
  }, {
    icon: 'fas fa-biohazard'
  }, {
    icon: 'fas fa-birthday-cake'
  }, {
    icon: 'fas fa-blender'
  }, {
    icon: 'fas fa-blender-phone'
  }, {
    icon: 'fas fa-blind'
  }, {
    icon: 'fas fa-blog'
  }, {
    icon: 'fas fa-bold'
  }, {
    icon: 'fas fa-bolt'
  }, {
    icon: 'fas fa-bomb'
  }, {
    icon: 'fas fa-bone'
  }, {
    icon: 'fas fa-bong'
  }, {
    icon: 'fas fa-book'
  }, {
    icon: 'fas fa-book-dead'
  }, {
    icon: 'fas fa-book-medical'
  }, {
    icon: 'fas fa-book-open'
  }, {
    icon: 'fas fa-book-reader'
  }, {
    icon: 'fas fa-bookmark'
  }, {
    icon: 'fas fa-border-all'
  }, {
    icon: 'fas fa-border-none'
  }, {
    icon: 'fas fa-border-style'
  }, {
    icon: 'fas fa-bowling-ball'
  }, {
    icon: 'fas fa-box'
  }, {
    icon: 'fas fa-box-open'
  }, {
    icon: 'fas fa-boxes'
  }, {
    icon: 'fas fa-braille'
  }, {
    icon: 'fas fa-brain'
  }, {
    icon: 'fas fa-bread-slice'
  }, {
    icon: 'fas fa-briefcase'
  }, {
    icon: 'fas fa-briefcase-medical'
  }, {
    icon: 'fas fa-broadcast-tower'
  }, {
    icon: 'fas fa-broom'
  }, {
    icon: 'fas fa-brush'
  }, {
    icon: 'fas fa-bug'
  }, {
    icon: 'fas fa-building'
  }, {
    icon: 'fas fa-bullhorn'
  }, {
    icon: 'fas fa-bullseye'
  }, {
    icon: 'fas fa-burn'
  }, {
    icon: 'fas fa-bus'
  }, {
    icon: 'fas fa-bus-alt'
  }, {
    icon: 'fas fa-business-time'
  }, {
    icon: 'fas fa-calculator'
  }, {
    icon: 'fas fa-calendar'
  }, {
    icon: 'fas fa-calendar-alt'
  }, {
    icon: 'fas fa-calendar-check'
  }, {
    icon: 'fas fa-calendar-day'
  }, {
    icon: 'fas fa-calendar-minus'
  }, {
    icon: 'fas fa-calendar-plus'
  }, {
    icon: 'fas fa-calendar-times'
  }, {
    icon: 'fas fa-calendar-week'
  }, {
    icon: 'fas fa-camera'
  }, {
    icon: 'fas fa-camera-retro'
  }, {
    icon: 'fas fa-campground'
  }, {
    icon: 'fas fa-candy-cane'
  }, {
    icon: 'fas fa-cannabis'
  }, {
    icon: 'fas fa-capsules'
  }, {
    icon: 'fas fa-car'
  }, {
    icon: 'fas fa-car-alt'
  }, {
    icon: 'fas fa-car-battery'
  }, {
    icon: 'fas fa-car-crash'
  }, {
    icon: 'fas fa-car-side'
  }, {
    icon: 'fas fa-caravan'
  }, {
    icon: 'fas fa-caret-down'
  }, {
    icon: 'fas fa-caret-left'
  }, {
    icon: 'fas fa-caret-right'
  }, {
    icon: 'fas fa-caret-square-down'
  }, {
    icon: 'fas fa-caret-square-left'
  }, {
    icon: 'fas fa-caret-square-right'
  }, {
    icon: 'fas fa-caret-square-up'
  }, {
    icon: 'fas fa-caret-up'
  }, {
    icon: 'fas fa-carrot'
  }, {
    icon: 'fas fa-cart-arrow-down'
  }, {
    icon: 'fas fa-cart-plus'
  }, {
    icon: 'fas fa-cash-register'
  }, {
    icon: 'fas fa-cat'
  }, {
    icon: 'fas fa-certificate'
  }, {
    icon: 'fas fa-chair'
  }, {
    icon: 'fas fa-chalkboard'
  }, {
    icon: 'fas fa-chalkboard-teacher'
  }, {
    icon: 'fas fa-charging-station'
  }, {
    icon: 'fas fa-chart-area'
  }, {
    icon: 'fas fa-chart-bar'
  }, {
    icon: 'fas fa-chart-line'
  }, {
    icon: 'fas fa-chart-pie'
  }, {
    icon: 'fas fa-check'
  }, {
    icon: 'fas fa-check-circle'
  }, {
    icon: 'fas fa-check-double'
  }, {
    icon: 'fas fa-check-square'
  }, {
    icon: 'fas fa-cheese'
  }, {
    icon: 'fas fa-chess'
  }, {
    icon: 'fas fa-chess-bishop'
  }, {
    icon: 'fas fa-chess-board'
  }, {
    icon: 'fas fa-chess-king'
  }, {
    icon: 'fas fa-chess-knight'
  }, {
    icon: 'fas fa-chess-pawn'
  }, {
    icon: 'fas fa-chess-queen'
  }, {
    icon: 'fas fa-chess-rook'
  }, {
    icon: 'fas fa-chevron-circle-down'
  }, {
    icon: 'fas fa-chevron-circle-left'
  }, {
    icon: 'fas fa-chevron-circle-right'
  }, {
    icon: 'fas fa-chevron-circle-up'
  }, {
    icon: 'fas fa-chevron-down'
  }, {
    icon: 'fas fa-chevron-left'
  }, {
    icon: 'fas fa-chevron-right'
  }, {
    icon: 'fas fa-chevron-up'
  }, {
    icon: 'fas fa-child'
  }, {
    icon: 'fas fa-church'
  }, {
    icon: 'fas fa-circle'
  }, {
    icon: 'fas fa-circle-notch'
  }, {
    icon: 'fas fa-city'
  }, {
    icon: 'fas fa-clinic-medical'
  }, {
    icon: 'fas fa-clipboard'
  }, {
    icon: 'fas fa-clipboard-check'
  }, {
    icon: 'fas fa-clipboard-list'
  }, {
    icon: 'fas fa-clock'
  }, {
    icon: 'fas fa-clone'
  }, {
    icon: 'fas fa-closed-captioning'
  }, {
    icon: 'fas fa-cloud'
  }, {
    icon: 'fas fa-cloud-download-alt'
  }, {
    icon: 'fas fa-cloud-meatball'
  }, {
    icon: 'fas fa-cloud-moon'
  }, {
    icon: 'fas fa-cloud-moon-rain'
  }, {
    icon: 'fas fa-cloud-rain'
  }, {
    icon: 'fas fa-cloud-showers-heavy'
  }, {
    icon: 'fas fa-cloud-sun'
  }, {
    icon: 'fas fa-cloud-sun-rain'
  }, {
    icon: 'fas fa-cloud-upload-alt'
  }, {
    icon: 'fas fa-cocktail'
  }, {
    icon: 'fas fa-code'
  }, {
    icon: 'fas fa-code-branch'
  }, {
    icon: 'fas fa-coffee'
  }, {
    icon: 'fas fa-cog'
  }, {
    icon: 'fas fa-cogs'
  }, {
    icon: 'fas fa-coins'
  }, {
    icon: 'fas fa-columns'
  }, {
    icon: 'fas fa-comment'
  }, {
    icon: 'fas fa-comment-alt'
  }, {
    icon: 'fas fa-comment-dollar'
  }, {
    icon: 'fas fa-comment-dots'
  }, {
    icon: 'fas fa-comment-medical'
  }, {
    icon: 'fas fa-comment-slash'
  }, {
    icon: 'fas fa-comments'
  }, {
    icon: 'fas fa-comments-dollar'
  }, {
    icon: 'fas fa-compact-disc'
  }, {
    icon: 'fas fa-compass'
  }, {
    icon: 'fas fa-compress'
  }, {
    icon: 'fas fa-compress-alt'
  }, {
    icon: 'fas fa-compress-arrows-alt'
  }, {
    icon: 'fas fa-concierge-bell'
  }, {
    icon: 'fas fa-cookie'
  }, {
    icon: 'fas fa-cookie-bite'
  }, {
    icon: 'fas fa-copy'
  }, {
    icon: 'fas fa-copyright'
  }, {
    icon: 'fas fa-couch'
  }, {
    icon: 'fas fa-credit-card'
  }, {
    icon: 'fas fa-crop'
  }, {
    icon: 'fas fa-crop-alt'
  }, {
    icon: 'fas fa-cross'
  }, {
    icon: 'fas fa-crosshairs'
  }, {
    icon: 'fas fa-crow'
  }, {
    icon: 'fas fa-crown'
  }, {
    icon: 'fas fa-crutch'
  }, {
    icon: 'fas fa-cube'
  }, {
    icon: 'fas fa-cubes'
  }, {
    icon: 'fas fa-cut'
  }, {
    icon: 'fas fa-database'
  }, {
    icon: 'fas fa-deaf'
  }, {
    icon: 'fas fa-democrat'
  }, {
    icon: 'fas fa-desktop'
  }, {
    icon: 'fas fa-dharmachakra'
  }, {
    icon: 'fas fa-diagnoses'
  }, {
    icon: 'fas fa-dice'
  }, {
    icon: 'fas fa-dice-d20'
  }, {
    icon: 'fas fa-dice-d6'
  }, {
    icon: 'fas fa-dice-five'
  }, {
    icon: 'fas fa-dice-four'
  }, {
    icon: 'fas fa-dice-one'
  }, {
    icon: 'fas fa-dice-six'
  }, {
    icon: 'fas fa-dice-three'
  }, {
    icon: 'fas fa-dice-two'
  }, {
    icon: 'fas fa-digital-tachograph'
  }, {
    icon: 'fas fa-directions'
  }, {
    icon: 'fas fa-divide'
  }, {
    icon: 'fas fa-dizzy'
  }, {
    icon: 'fas fa-dna'
  }, {
    icon: 'fas fa-dog'
  }, {
    icon: 'fas fa-dollar-sign'
  }, {
    icon: 'fas fa-dolly'
  }, {
    icon: 'fas fa-dolly-flatbed'
  }, {
    icon: 'fas fa-donate'
  }, {
    icon: 'fas fa-door-closed'
  }, {
    icon: 'fas fa-door-open'
  }, {
    icon: 'fas fa-dot-circle'
  }, {
    icon: 'fas fa-dove'
  }, {
    icon: 'fas fa-download'
  }, {
    icon: 'fas fa-drafting-compass'
  }, {
    icon: 'fas fa-dragon'
  }, {
    icon: 'fas fa-draw-polygon'
  }, {
    icon: 'fas fa-drum'
  }, {
    icon: 'fas fa-drum-steelpan'
  }, {
    icon: 'fas fa-drumstick-bite'
  }, {
    icon: 'fas fa-dumbbell'
  }, {
    icon: 'fas fa-dumpster'
  }, {
    icon: 'fas fa-dumpster-fire'
  }, {
    icon: 'fas fa-dungeon'
  }, {
    icon: 'fas fa-edit'
  }, {
    icon: 'fas fa-egg'
  }, {
    icon: 'fas fa-eject'
  }, {
    icon: 'fas fa-ellipsis-h'
  }, {
    icon: 'fas fa-ellipsis-v'
  }, {
    icon: 'fas fa-envelope'
  }, {
    icon: 'fas fa-envelope-open'
  }, {
    icon: 'fas fa-envelope-open-text'
  }, {
    icon: 'fas fa-envelope-square'
  }, {
    icon: 'fas fa-equals'
  }, {
    icon: 'fas fa-eraser'
  }, {
    icon: 'fas fa-ethernet'
  }, {
    icon: 'fas fa-euro-sign'
  }, {
    icon: 'fas fa-exchange-alt'
  }, {
    icon: 'fas fa-exclamation'
  }, {
    icon: 'fas fa-exclamation-circle'
  }, {
    icon: 'fas fa-exclamation-triangle'
  }, {
    icon: 'fas fa-expand'
  }, {
    icon: 'fas fa-expand-alt'
  }, {
    icon: 'fas fa-expand-arrows-alt'
  }, {
    icon: 'fas fa-external-link-alt'
  }, {
    icon: 'fas fa-external-link-square-alt'
  }, {
    icon: 'fas fa-eye'
  }, {
    icon: 'fas fa-eye-dropper'
  }, {
    icon: 'fas fa-eye-slash'
  }, {
    icon: 'fas fa-fan'
  }, {
    icon: 'fas fa-fast-backward'
  }, {
    icon: 'fas fa-fast-forward'
  }, {
    icon: 'fas fa-fax'
  }, {
    icon: 'fas fa-feather'
  }, {
    icon: 'fas fa-feather-alt'
  }, {
    icon: 'fas fa-female'
  }, {
    icon: 'fas fa-fighter-jet'
  }, {
    icon: 'fas fa-file'
  }, {
    icon: 'fas fa-file-alt'
  }, {
    icon: 'fas fa-file-archive'
  }, {
    icon: 'fas fa-file-audio'
  }, {
    icon: 'fas fa-file-code'
  }, {
    icon: 'fas fa-file-contract'
  }, {
    icon: 'fas fa-file-csv'
  }, {
    icon: 'fas fa-file-download'
  }, {
    icon: 'fas fa-file-excel'
  }, {
    icon: 'fas fa-file-export'
  }, {
    icon: 'fas fa-file-image'
  }, {
    icon: 'fas fa-file-import'
  }, {
    icon: 'fas fa-file-invoice'
  }, {
    icon: 'fas fa-file-invoice-dollar'
  }, {
    icon: 'fas fa-file-medical'
  }, {
    icon: 'fas fa-file-medical-alt'
  }, {
    icon: 'fas fa-file-pdf'
  }, {
    icon: 'fas fa-file-powerpoint'
  }, {
    icon: 'fas fa-file-prescription'
  }, {
    icon: 'fas fa-file-signature'
  }, {
    icon: 'fas fa-file-upload'
  }, {
    icon: 'fas fa-file-video'
  }, {
    icon: 'fas fa-file-word'
  }, {
    icon: 'fas fa-fill'
  }, {
    icon: 'fas fa-fill-drip'
  }, {
    icon: 'fas fa-film'
  }, {
    icon: 'fas fa-filter'
  }, {
    icon: 'fas fa-fingerprint'
  }, {
    icon: 'fas fa-fire'
  }, {
    icon: 'fas fa-fire-alt'
  }, {
    icon: 'fas fa-fire-extinguisher'
  }, {
    icon: 'fas fa-first-aid'
  }, {
    icon: 'fas fa-fish'
  }, {
    icon: 'fas fa-fist-raised'
  }, {
    icon: 'fas fa-flag'
  }, {
    icon: 'fas fa-flag-checkered'
  }, {
    icon: 'fas fa-flag-usa'
  }, {
    icon: 'fas fa-flask'
  }, {
    icon: 'fas fa-flushed'
  }, {
    icon: 'fas fa-folder'
  }, {
    icon: 'fas fa-folder-minus'
  }, {
    icon: 'fas fa-folder-open'
  }, {
    icon: 'fas fa-folder-plus'
  }, {
    icon: 'fas fa-font'
  }, {
    icon: 'fas fa-football-ball'
  }, {
    icon: 'fas fa-forward'
  }, {
    icon: 'fas fa-frog'
  }, {
    icon: 'fas fa-frown'
  }, {
    icon: 'fas fa-frown-open'
  }, {
    icon: 'fas fa-funnel-dollar'
  }, {
    icon: 'fas fa-futbol'
  }, {
    icon: 'fas fa-gamepad'
  }, {
    icon: 'fas fa-gas-pump'
  }, {
    icon: 'fas fa-gavel'
  }, {
    icon: 'fas fa-gem'
  }, {
    icon: 'fas fa-genderless'
  }, {
    icon: 'fas fa-ghost'
  }, {
    icon: 'fas fa-gift'
  }, {
    icon: 'fas fa-gifts'
  }, {
    icon: 'fas fa-glass-cheers'
  }, {
    icon: 'fas fa-glass-martini'
  }, {
    icon: 'fas fa-glass-martini-alt'
  }, {
    icon: 'fas fa-glass-whiskey'
  }, {
    icon: 'fas fa-glasses'
  }, {
    icon: 'fas fa-globe'
  }, {
    icon: 'fas fa-globe-africa'
  }, {
    icon: 'fas fa-globe-americas'
  }, {
    icon: 'fas fa-globe-asia'
  }, {
    icon: 'fas fa-globe-europe'
  }, {
    icon: 'fas fa-golf-ball'
  }, {
    icon: 'fas fa-gopuram'
  }, {
    icon: 'fas fa-graduation-cap'
  }, {
    icon: 'fas fa-greater-than'
  }, {
    icon: 'fas fa-greater-than-equal'
  }, {
    icon: 'fas fa-grimace'
  }, {
    icon: 'fas fa-grin'
  }, {
    icon: 'fas fa-grin-alt'
  }, {
    icon: 'fas fa-grin-beam'
  }, {
    icon: 'fas fa-grin-beam-sweat'
  }, {
    icon: 'fas fa-grin-hearts'
  }, {
    icon: 'fas fa-grin-squint'
  }, {
    icon: 'fas fa-grin-squint-tears'
  }, {
    icon: 'fas fa-grin-stars'
  }, {
    icon: 'fas fa-grin-tears'
  }, {
    icon: 'fas fa-grin-tongue'
  }, {
    icon: 'fas fa-grin-tongue-squint'
  }, {
    icon: 'fas fa-grin-tongue-wink'
  }, {
    icon: 'fas fa-grin-wink'
  }, {
    icon: 'fas fa-grip-horizontal'
  }, {
    icon: 'fas fa-grip-lines'
  }, {
    icon: 'fas fa-grip-lines-vertical'
  }, {
    icon: 'fas fa-grip-vertical'
  }, {
    icon: 'fas fa-guitar'
  }, {
    icon: 'fas fa-h-square'
  }, {
    icon: 'fas fa-hamburger'
  }, {
    icon: 'fas fa-hammer'
  }, {
    icon: 'fas fa-hamsa'
  }, {
    icon: 'fas fa-hand-holding'
  }, {
    icon: 'fas fa-hand-holding-heart'
  }, {
    icon: 'fas fa-hand-holding-usd'
  }, {
    icon: 'fas fa-hand-lizard'
  }, {
    icon: 'fas fa-hand-middle-finger'
  }, {
    icon: 'fas fa-hand-paper'
  }, {
    icon: 'fas fa-hand-peace'
  }, {
    icon: 'fas fa-hand-point-down'
  }, {
    icon: 'fas fa-hand-point-left'
  }, {
    icon: 'fas fa-hand-point-right'
  }, {
    icon: 'fas fa-hand-point-up'
  }, {
    icon: 'fas fa-hand-pointer'
  }, {
    icon: 'fas fa-hand-rock'
  }, {
    icon: 'fas fa-hand-scissors'
  }, {
    icon: 'fas fa-hand-spock'
  }, {
    icon: 'fas fa-hands'
  }, {
    icon: 'fas fa-hands-helping'
  }, {
    icon: 'fas fa-handshake'
  }, {
    icon: 'fas fa-hanukiah'
  }, {
    icon: 'fas fa-hard-hat'
  }, {
    icon: 'fas fa-hashtag'
  }, {
    icon: 'fas fa-hat-cowboy'
  }, {
    icon: 'fas fa-hat-cowboy-side'
  }, {
    icon: 'fas fa-hat-wizard'
  }, {
    icon: 'fas fa-hdd'
  }, {
    icon: 'fas fa-heading'
  }, {
    icon: 'fas fa-headphones'
  }, {
    icon: 'fas fa-headphones-alt'
  }, {
    icon: 'fas fa-headset'
  }, {
    icon: 'fas fa-heart'
  }, {
    icon: 'fas fa-heart-broken'
  }, {
    icon: 'fas fa-heartbeat'
  }, {
    icon: 'fas fa-helicopter'
  }, {
    icon: 'fas fa-highlighter'
  }, {
    icon: 'fas fa-hiking'
  }, {
    icon: 'fas fa-hippo'
  }, {
    icon: 'fas fa-history'
  }, {
    icon: 'fas fa-hockey-puck'
  }, {
    icon: 'fas fa-holly-berry'
  }, {
    icon: 'fas fa-home'
  }, {
    icon: 'fas fa-horse'
  }, {
    icon: 'fas fa-horse-head'
  }, {
    icon: 'fas fa-hospital'
  }, {
    icon: 'fas fa-hospital-alt'
  }, {
    icon: 'fas fa-hospital-symbol'
  }, {
    icon: 'fas fa-hot-tub'
  }, {
    icon: 'fas fa-hotdog'
  }, {
    icon: 'fas fa-hotel'
  }, {
    icon: 'fas fa-hourglass'
  }, {
    icon: 'fas fa-hourglass-end'
  }, {
    icon: 'fas fa-hourglass-half'
  }, {
    icon: 'fas fa-hourglass-start'
  }, {
    icon: 'fas fa-house-damage'
  }, {
    icon: 'fas fa-hryvnia'
  }, {
    icon: 'fas fa-i-cursor'
  }, {
    icon: 'fas fa-ice-cream'
  }, {
    icon: 'fas fa-icicles'
  }, {
    icon: 'fas fa-icons'
  }, {
    icon: 'fas fa-id-badge'
  }, {
    icon: 'fas fa-id-card'
  }, {
    icon: 'fas fa-id-card-alt'
  }, {
    icon: 'fas fa-igloo'
  }, {
    icon: 'fas fa-image'
  }, {
    icon: 'fas fa-images'
  }, {
    icon: 'fas fa-inbox'
  }, {
    icon: 'fas fa-indent'
  }, {
    icon: 'fas fa-industry'
  }, {
    icon: 'fas fa-infinity'
  }, {
    icon: 'fas fa-info'
  }, {
    icon: 'fas fa-info-circle'
  }, {
    icon: 'fas fa-italic'
  }, {
    icon: 'fas fa-jedi'
  }, {
    icon: 'fas fa-joint'
  }, {
    icon: 'fas fa-journal-whills'
  }, {
    icon: 'fas fa-kaaba'
  }, {
    icon: 'fas fa-key'
  }, {
    icon: 'fas fa-keyboard'
  }, {
    icon: 'fas fa-khanda'
  }, {
    icon: 'fas fa-kiss'
  }, {
    icon: 'fas fa-kiss-beam'
  }, {
    icon: 'fas fa-kiss-wink-heart'
  }, {
    icon: 'fas fa-kiwi-bird'
  }, {
    icon: 'fas fa-landmark'
  }, {
    icon: 'fas fa-language'
  }, {
    icon: 'fas fa-laptop'
  }, {
    icon: 'fas fa-laptop-code'
  }, {
    icon: 'fas fa-laptop-medical'
  }, {
    icon: 'fas fa-laugh'
  }, {
    icon: 'fas fa-laugh-beam'
  }, {
    icon: 'fas fa-laugh-squint'
  }, {
    icon: 'fas fa-laugh-wink'
  }, {
    icon: 'fas fa-layer-group'
  }, {
    icon: 'fas fa-leaf'
  }, {
    icon: 'fas fa-lemon'
  }, {
    icon: 'fas fa-less-than'
  }, {
    icon: 'fas fa-less-than-equal'
  }, {
    icon: 'fas fa-level-down-alt'
  }, {
    icon: 'fas fa-level-up-alt'
  }, {
    icon: 'fas fa-life-ring'
  }, {
    icon: 'fas fa-lightbulb'
  }, {
    icon: 'fas fa-link'
  }, {
    icon: 'fas fa-lira-sign'
  }, {
    icon: 'fas fa-list'
  }, {
    icon: 'fas fa-list-alt'
  }, {
    icon: 'fas fa-list-ol'
  }, {
    icon: 'fas fa-list-ul'
  }, {
    icon: 'fas fa-location-arrow'
  }, {
    icon: 'fas fa-lock'
  }, {
    icon: 'fas fa-lock-open'
  }, {
    icon: 'fas fa-long-arrow-alt-down'
  }, {
    icon: 'fas fa-long-arrow-alt-left'
  }, {
    icon: 'fas fa-long-arrow-alt-right'
  }, {
    icon: 'fas fa-long-arrow-alt-up'
  }, {
    icon: 'fas fa-low-vision'
  }, {
    icon: 'fas fa-luggage-cart'
  }, {
    icon: 'fas fa-magic'
  }, {
    icon: 'fas fa-magnet'
  }, {
    icon: 'fas fa-mail-bulk'
  }, {
    icon: 'fas fa-male'
  }, {
    icon: 'fas fa-map'
  }, {
    icon: 'fas fa-map-marked'
  }, {
    icon: 'fas fa-map-marked-alt'
  }, {
    icon: 'fas fa-map-marker'
  }, {
    icon: 'fas fa-map-marker-alt'
  }, {
    icon: 'fas fa-map-pin'
  }, {
    icon: 'fas fa-map-signs'
  }, {
    icon: 'fas fa-marker'
  }, {
    icon: 'fas fa-mars'
  }, {
    icon: 'fas fa-mars-double'
  }, {
    icon: 'fas fa-mars-stroke'
  }, {
    icon: 'fas fa-mars-stroke-h'
  }, {
    icon: 'fas fa-mars-stroke-v'
  }, {
    icon: 'fas fa-mask'
  }, {
    icon: 'fas fa-medal'
  }, {
    icon: 'fas fa-medkit'
  }, {
    icon: 'fas fa-meh'
  }, {
    icon: 'fas fa-meh-blank'
  }, {
    icon: 'fas fa-meh-rolling-eyes'
  }, {
    icon: 'fas fa-memory'
  }, {
    icon: 'fas fa-menorah'
  }, {
    icon: 'fas fa-mercury'
  }, {
    icon: 'fas fa-meteor'
  }, {
    icon: 'fas fa-microchip'
  }, {
    icon: 'fas fa-microphone'
  }, {
    icon: 'fas fa-microphone-alt'
  }, {
    icon: 'fas fa-microphone-alt-slash'
  }, {
    icon: 'fas fa-microphone-slash'
  }, {
    icon: 'fas fa-microscope'
  }, {
    icon: 'fas fa-minus'
  }, {
    icon: 'fas fa-minus-circle'
  }, {
    icon: 'fas fa-minus-square'
  }, {
    icon: 'fas fa-mitten'
  }, {
    icon: 'fas fa-mobile'
  }, {
    icon: 'fas fa-mobile-alt'
  }, {
    icon: 'fas fa-money-bill'
  }, {
    icon: 'fas fa-money-bill-alt'
  }, {
    icon: 'fas fa-money-bill-wave'
  }, {
    icon: 'fas fa-money-bill-wave-alt'
  }, {
    icon: 'fas fa-money-check'
  }, {
    icon: 'fas fa-money-check-alt'
  }, {
    icon: 'fas fa-monument'
  }, {
    icon: 'fas fa-moon'
  }, {
    icon: 'fas fa-mortar-pestle'
  }, {
    icon: 'fas fa-mosque'
  }, {
    icon: 'fas fa-motorcycle'
  }, {
    icon: 'fas fa-mountain'
  }, {
    icon: 'fas fa-mouse'
  }, {
    icon: 'fas fa-mouse-pointer'
  }, {
    icon: 'fas fa-mug-hot'
  }, {
    icon: 'fas fa-music'
  }, {
    icon: 'fas fa-network-wired'
  }, {
    icon: 'fas fa-neuter'
  }, {
    icon: 'fas fa-newspaper'
  }, {
    icon: 'fas fa-not-equal'
  }, {
    icon: 'fas fa-notes-medical'
  }, {
    icon: 'fas fa-object-group'
  }, {
    icon: 'fas fa-object-ungroup'
  }, {
    icon: 'fas fa-oil-can'
  }, {
    icon: 'fas fa-om'
  }, {
    icon: 'fas fa-otter'
  }, {
    icon: 'fas fa-outdent'
  }, {
    icon: 'fas fa-pager'
  }, {
    icon: 'fas fa-paint-brush'
  }, {
    icon: 'fas fa-paint-roller'
  }, {
    icon: 'fas fa-palette'
  }, {
    icon: 'fas fa-pallet'
  }, {
    icon: 'fas fa-paper-plane'
  }, {
    icon: 'fas fa-paperclip'
  }, {
    icon: 'fas fa-parachute-box'
  }, {
    icon: 'fas fa-paragraph'
  }, {
    icon: 'fas fa-parking'
  }, {
    icon: 'fas fa-passport'
  }, {
    icon: 'fas fa-pastafarianism'
  }, {
    icon: 'fas fa-paste'
  }, {
    icon: 'fas fa-pause'
  }, {
    icon: 'fas fa-pause-circle'
  }, {
    icon: 'fas fa-paw'
  }, {
    icon: 'fas fa-peace'
  }, {
    icon: 'fas fa-pen'
  }, {
    icon: 'fas fa-pen-alt'
  }, {
    icon: 'fas fa-pen-fancy'
  }, {
    icon: 'fas fa-pen-nib'
  }, {
    icon: 'fas fa-pen-square'
  }, {
    icon: 'fas fa-pencil-alt'
  }, {
    icon: 'fas fa-pencil-ruler'
  }, {
    icon: 'fas fa-people-carry'
  }, {
    icon: 'fas fa-pepper-hot'
  }, {
    icon: 'fas fa-percent'
  }, {
    icon: 'fas fa-percentage'
  }, {
    icon: 'fas fa-person-booth'
  }, {
    icon: 'fas fa-phone'
  }, {
    icon: 'fas fa-phone-alt'
  }, {
    icon: 'fas fa-phone-slash'
  }, {
    icon: 'fas fa-phone-square'
  }, {
    icon: 'fas fa-phone-square-alt'
  }, {
    icon: 'fas fa-phone-volume'
  }, {
    icon: 'fas fa-photo-video'
  }, {
    icon: 'fas fa-piggy-bank'
  }, {
    icon: 'fas fa-pills'
  }, {
    icon: 'fas fa-pizza-slice'
  }, {
    icon: 'fas fa-place-of-worship'
  }, {
    icon: 'fas fa-plane'
  }, {
    icon: 'fas fa-plane-arrival'
  }, {
    icon: 'fas fa-plane-departure'
  }, {
    icon: 'fas fa-play'
  }, {
    icon: 'fas fa-play-circle'
  }, {
    icon: 'fas fa-plug'
  }, {
    icon: 'fas fa-plus'
  }, {
    icon: 'fas fa-plus-circle'
  }, {
    icon: 'fas fa-plus-square'
  }, {
    icon: 'fas fa-podcast'
  }, {
    icon: 'fas fa-poll'
  }, {
    icon: 'fas fa-poll-h'
  }, {
    icon: 'fas fa-poo'
  }, {
    icon: 'fas fa-poo-storm'
  }, {
    icon: 'fas fa-poop'
  }, {
    icon: 'fas fa-portrait'
  }, {
    icon: 'fas fa-pound-sign'
  }, {
    icon: 'fas fa-power-off'
  }, {
    icon: 'fas fa-pray'
  }, {
    icon: 'fas fa-praying-hands'
  }, {
    icon: 'fas fa-prescription'
  }, {
    icon: 'fas fa-prescription-bottle'
  }, {
    icon: 'fas fa-prescription-bottle-alt'
  }, {
    icon: 'fas fa-print'
  }, {
    icon: 'fas fa-procedures'
  }, {
    icon: 'fas fa-project-diagram'
  }, {
    icon: 'fas fa-puzzle-piece'
  }, {
    icon: 'fas fa-qrcode'
  }, {
    icon: 'fas fa-question'
  }, {
    icon: 'fas fa-question-circle'
  }, {
    icon: 'fas fa-quidditch'
  }, {
    icon: 'fas fa-quote-left'
  }, {
    icon: 'fas fa-quote-right'
  }, {
    icon: 'fas fa-quran'
  }, {
    icon: 'fas fa-radiation'
  }, {
    icon: 'fas fa-radiation-alt'
  }, {
    icon: 'fas fa-rainbow'
  }, {
    icon: 'fas fa-random'
  }, {
    icon: 'fas fa-receipt'
  }, {
    icon: 'fas fa-record-vinyl'
  }, {
    icon: 'fas fa-recycle'
  }, {
    icon: 'fas fa-redo'
  }, {
    icon: 'fas fa-redo-alt'
  }, {
    icon: 'fas fa-registered'
  }, {
    icon: 'fas fa-remove-format'
  }, {
    icon: 'fas fa-reply'
  }, {
    icon: 'fas fa-reply-all'
  }, {
    icon: 'fas fa-republican'
  }, {
    icon: 'fas fa-restroom'
  }, {
    icon: 'fas fa-retweet'
  }, {
    icon: 'fas fa-ribbon'
  }, {
    icon: 'fas fa-ring'
  }, {
    icon: 'fas fa-road'
  }, {
    icon: 'fas fa-robot'
  }, {
    icon: 'fas fa-rocket'
  }, {
    icon: 'fas fa-route'
  }, {
    icon: 'fas fa-rss'
  }, {
    icon: 'fas fa-rss-square'
  }, {
    icon: 'fas fa-ruble-sign'
  }, {
    icon: 'fas fa-ruler'
  }, {
    icon: 'fas fa-ruler-combined'
  }, {
    icon: 'fas fa-ruler-horizontal'
  }, {
    icon: 'fas fa-ruler-vertical'
  }, {
    icon: 'fas fa-running'
  }, {
    icon: 'fas fa-rupee-sign'
  }, {
    icon: 'fas fa-sad-cry'
  }, {
    icon: 'fas fa-sad-tear'
  }, {
    icon: 'fas fa-satellite'
  }, {
    icon: 'fas fa-satellite-dish'
  }, {
    icon: 'fas fa-save'
  }, {
    icon: 'fas fa-school'
  }, {
    icon: 'fas fa-screwdriver'
  }, {
    icon: 'fas fa-scroll'
  }, {
    icon: 'fas fa-sd-card'
  }, {
    icon: 'fas fa-search'
  }, {
    icon: 'fas fa-search-dollar'
  }, {
    icon: 'fas fa-search-location'
  }, {
    icon: 'fas fa-search-minus'
  }, {
    icon: 'fas fa-search-plus'
  }, {
    icon: 'fas fa-seedling'
  }, {
    icon: 'fas fa-server'
  }, {
    icon: 'fas fa-shapes'
  }, {
    icon: 'fas fa-share'
  }, {
    icon: 'fas fa-share-alt'
  }, {
    icon: 'fas fa-share-alt-square'
  }, {
    icon: 'fas fa-share-square'
  }, {
    icon: 'fas fa-shekel-sign'
  }, {
    icon: 'fas fa-shield-alt'
  }, {
    icon: 'fas fa-ship'
  }, {
    icon: 'fas fa-shipping-fast'
  }, {
    icon: 'fas fa-shoe-prints'
  }, {
    icon: 'fas fa-shopping-bag'
  }, {
    icon: 'fas fa-shopping-basket'
  }, {
    icon: 'fas fa-shopping-cart'
  }, {
    icon: 'fas fa-shower'
  }, {
    icon: 'fas fa-shuttle-van'
  }, {
    icon: 'fas fa-sign'
  }, {
    icon: 'fas fa-sign-in-alt'
  }, {
    icon: 'fas fa-sign-language'
  }, {
    icon: 'fas fa-sign-out-alt'
  }, {
    icon: 'fas fa-signal'
  }, {
    icon: 'fas fa-signature'
  }, {
    icon: 'fas fa-sim-card'
  }, {
    icon: 'fas fa-sitemap'
  }, {
    icon: 'fas fa-skating'
  }, {
    icon: 'fas fa-skiing'
  }, {
    icon: 'fas fa-skiing-nordic'
  }, {
    icon: 'fas fa-skull'
  }, {
    icon: 'fas fa-skull-crossbones'
  }, {
    icon: 'fas fa-slash'
  }, {
    icon: 'fas fa-sleigh'
  }, {
    icon: 'fas fa-sliders-h'
  }, {
    icon: 'fas fa-smile'
  }, {
    icon: 'fas fa-smile-beam'
  }, {
    icon: 'fas fa-smile-wink'
  }, {
    icon: 'fas fa-smog'
  }, {
    icon: 'fas fa-smoking'
  }, {
    icon: 'fas fa-smoking-ban'
  }, {
    icon: 'fas fa-sms'
  }, {
    icon: 'fas fa-snowboarding'
  }, {
    icon: 'fas fa-snowflake'
  }, {
    icon: 'fas fa-snowman'
  }, {
    icon: 'fas fa-snowplow'
  }, {
    icon: 'fas fa-socks'
  }, {
    icon: 'fas fa-solar-panel'
  }, {
    icon: 'fas fa-sort'
  }, {
    icon: 'fas fa-sort-alpha-down'
  }, {
    icon: 'fas fa-sort-alpha-down-alt'
  }, {
    icon: 'fas fa-sort-alpha-up'
  }, {
    icon: 'fas fa-sort-alpha-up-alt'
  }, {
    icon: 'fas fa-sort-amount-down'
  }, {
    icon: 'fas fa-sort-amount-down-alt'
  }, {
    icon: 'fas fa-sort-amount-up'
  }, {
    icon: 'fas fa-sort-amount-up-alt'
  }, {
    icon: 'fas fa-sort-down'
  }, {
    icon: 'fas fa-sort-numeric-down'
  }, {
    icon: 'fas fa-sort-numeric-down-alt'
  }, {
    icon: 'fas fa-sort-numeric-up'
  }, {
    icon: 'fas fa-sort-numeric-up-alt'
  }, {
    icon: 'fas fa-sort-up'
  }, {
    icon: 'fas fa-spa'
  }, {
    icon: 'fas fa-space-shuttle'
  }, {
    icon: 'fas fa-spell-check'
  }, {
    icon: 'fas fa-spider'
  }, {
    icon: 'fas fa-spinner'
  }, {
    icon: 'fas fa-splotch'
  }, {
    icon: 'fas fa-spray-can'
  }, {
    icon: 'fas fa-square'
  }, {
    icon: 'fas fa-square-full'
  }, {
    icon: 'fas fa-square-root-alt'
  }, {
    icon: 'fas fa-stamp'
  }, {
    icon: 'fas fa-star'
  }, {
    icon: 'fas fa-star-and-crescent'
  }, {
    icon: 'fas fa-star-half'
  }, {
    icon: 'fas fa-star-half-alt'
  }, {
    icon: 'fas fa-star-of-david'
  }, {
    icon: 'fas fa-star-of-life'
  }, {
    icon: 'fas fa-step-backward'
  }, {
    icon: 'fas fa-step-forward'
  }, {
    icon: 'fas fa-stethoscope'
  }, {
    icon: 'fas fa-sticky-note'
  }, {
    icon: 'fas fa-stop'
  }, {
    icon: 'fas fa-stop-circle'
  }, {
    icon: 'fas fa-stopwatch'
  }, {
    icon: 'fas fa-store'
  }, {
    icon: 'fas fa-store-alt'
  }, {
    icon: 'fas fa-stream'
  }, {
    icon: 'fas fa-street-view'
  }, {
    icon: 'fas fa-strikethrough'
  }, {
    icon: 'fas fa-stroopwafel'
  }, {
    icon: 'fas fa-subscript'
  }, {
    icon: 'fas fa-subway'
  }, {
    icon: 'fas fa-suitcase'
  }, {
    icon: 'fas fa-suitcase-rolling'
  }, {
    icon: 'fas fa-sun'
  }, {
    icon: 'fas fa-superscript'
  }, {
    icon: 'fas fa-surprise'
  }, {
    icon: 'fas fa-swatchbook'
  }, {
    icon: 'fas fa-swimmer'
  }, {
    icon: 'fas fa-swimming-pool'
  }, {
    icon: 'fas fa-synagogue'
  }, {
    icon: 'fas fa-sync'
  }, {
    icon: 'fas fa-sync-alt'
  }, {
    icon: 'fas fa-syringe'
  }, {
    icon: 'fas fa-table'
  }, {
    icon: 'fas fa-table-tennis'
  }, {
    icon: 'fas fa-tablet'
  }, {
    icon: 'fas fa-tablet-alt'
  }, {
    icon: 'fas fa-tablets'
  }, {
    icon: 'fas fa-tachometer-alt'
  }, {
    icon: 'fas fa-tag'
  }, {
    icon: 'fas fa-tags'
  }, {
    icon: 'fas fa-tape'
  }, {
    icon: 'fas fa-tasks'
  }, {
    icon: 'fas fa-taxi'
  }, {
    icon: 'fas fa-teeth'
  }, {
    icon: 'fas fa-teeth-open'
  }, {
    icon: 'fas fa-temperature-high'
  }, {
    icon: 'fas fa-temperature-low'
  }, {
    icon: 'fas fa-tenge'
  }, {
    icon: 'fas fa-terminal'
  }, {
    icon: 'fas fa-text-height'
  }, {
    icon: 'fas fa-text-width'
  }, {
    icon: 'fas fa-th'
  }, {
    icon: 'fas fa-th-large'
  }, {
    icon: 'fas fa-th-list'
  }, {
    icon: 'fas fa-theater-masks'
  }, {
    icon: 'fas fa-thermometer'
  }, {
    icon: 'fas fa-thermometer-empty'
  }, {
    icon: 'fas fa-thermometer-full'
  }, {
    icon: 'fas fa-thermometer-half'
  }, {
    icon: 'fas fa-thermometer-quarter'
  }, {
    icon: 'fas fa-thermometer-three-quarters'
  }, {
    icon: 'fas fa-thumbs-down'
  }, {
    icon: 'fas fa-thumbs-up'
  }, {
    icon: 'fas fa-thumbtack'
  }, {
    icon: 'fas fa-ticket-alt'
  }, {
    icon: 'fas fa-times'
  }, {
    icon: 'fas fa-times-circle'
  }, {
    icon: 'fas fa-tint'
  }, {
    icon: 'fas fa-tint-slash'
  }, {
    icon: 'fas fa-tired'
  }, {
    icon: 'fas fa-toggle-off'
  }, {
    icon: 'fas fa-toggle-on'
  }, {
    icon: 'fas fa-toilet'
  }, {
    icon: 'fas fa-toilet-paper'
  }, {
    icon: 'fas fa-toolbox'
  }, {
    icon: 'fas fa-tools'
  }, {
    icon: 'fas fa-tooth'
  }, {
    icon: 'fas fa-torah'
  }, {
    icon: 'fas fa-torii-gate'
  }, {
    icon: 'fas fa-tractor'
  }, {
    icon: 'fas fa-trademark'
  }, {
    icon: 'fas fa-traffic-light'
  }, {
    icon: 'fas fa-trailer'
  }, {
    icon: 'fas fa-train'
  }, {
    icon: 'fas fa-tram'
  }, {
    icon: 'fas fa-transgender'
  }, {
    icon: 'fas fa-transgender-alt'
  }, {
    icon: 'fas fa-trash'
  }, {
    icon: 'fas fa-trash-alt'
  }, {
    icon: 'fas fa-trash-restore'
  }, {
    icon: 'fas fa-trash-restore-alt'
  }, {
    icon: 'fas fa-tree'
  }, {
    icon: 'fas fa-trophy'
  }, {
    icon: 'fas fa-truck'
  }, {
    icon: 'fas fa-truck-loading'
  }, {
    icon: 'fas fa-truck-monster'
  }, {
    icon: 'fas fa-truck-moving'
  }, {
    icon: 'fas fa-truck-pickup'
  }, {
    icon: 'fas fa-tshirt'
  }, {
    icon: 'fas fa-tty'
  }, {
    icon: 'fas fa-tv'
  }, {
    icon: 'fas fa-umbrella'
  }, {
    icon: 'fas fa-umbrella-beach'
  }, {
    icon: 'fas fa-underline'
  }, {
    icon: 'fas fa-undo'
  }, {
    icon: 'fas fa-undo-alt'
  }, {
    icon: 'fas fa-universal-access'
  }, {
    icon: 'fas fa-university'
  }, {
    icon: 'fas fa-unlink'
  }, {
    icon: 'fas fa-unlock'
  }, {
    icon: 'fas fa-unlock-alt'
  }, {
    icon: 'fas fa-upload'
  }, {
    icon: 'fas fa-user'
  }, {
    icon: 'fas fa-user-alt'
  }, {
    icon: 'fas fa-user-alt-slash'
  }, {
    icon: 'fas fa-user-astronaut'
  }, {
    icon: 'fas fa-user-check'
  }, {
    icon: 'fas fa-user-circle'
  }, {
    icon: 'fas fa-user-clock'
  }, {
    icon: 'fas fa-user-cog'
  }, {
    icon: 'fas fa-user-edit'
  }, {
    icon: 'fas fa-user-friends'
  }, {
    icon: 'fas fa-user-graduate'
  }, {
    icon: 'fas fa-user-injured'
  }, {
    icon: 'fas fa-user-lock'
  }, {
    icon: 'fas fa-user-md'
  }, {
    icon: 'fas fa-user-minus'
  }, {
    icon: 'fas fa-user-ninja'
  }, {
    icon: 'fas fa-user-nurse'
  }, {
    icon: 'fas fa-user-plus'
  }, {
    icon: 'fas fa-user-secret'
  }, {
    icon: 'fas fa-user-shield'
  }, {
    icon: 'fas fa-user-slash'
  }, {
    icon: 'fas fa-user-tag'
  }, {
    icon: 'fas fa-user-tie'
  }, {
    icon: 'fas fa-user-times'
  }, {
    icon: 'fas fa-users'
  }, {
    icon: 'fas fa-users-cog'
  }, {
    icon: 'fas fa-utensil-spoon'
  }, {
    icon: 'fas fa-utensils'
  }, {
    icon: 'fas fa-vector-square'
  }, {
    icon: 'fas fa-venus'
  }, {
    icon: 'fas fa-venus-double'
  }, {
    icon: 'fas fa-venus-mars'
  }, {
    icon: 'fas fa-vial'
  }, {
    icon: 'fas fa-vials'
  }, {
    icon: 'fas fa-video'
  }, {
    icon: 'fas fa-video-slash'
  }, {
    icon: 'fas fa-vihara'
  }, {
    icon: 'fas fa-voicemail'
  }, {
    icon: 'fas fa-volleyball-ball'
  }, {
    icon: 'fas fa-volume-down'
  }, {
    icon: 'fas fa-volume-mute'
  }, {
    icon: 'fas fa-volume-off'
  }, {
    icon: 'fas fa-volume-up'
  }, {
    icon: 'fas fa-vote-yea'
  }, {
    icon: 'fas fa-vr-cardboard'
  }, {
    icon: 'fas fa-walking'
  }, {
    icon: 'fas fa-wallet'
  }, {
    icon: 'fas fa-warehouse'
  }, {
    icon: 'fas fa-water'
  }, {
    icon: 'fas fa-wave-square'
  }, {
    icon: 'fas fa-weight'
  }, {
    icon: 'fas fa-weight-hanging'
  }, {
    icon: 'fas fa-wheelchair'
  }, {
    icon: 'fas fa-wifi'
  }, {
    icon: 'fas fa-wind'
  }, {
    icon: 'fas fa-window-close'
  }, {
    icon: 'fas fa-window-maximize'
  }, {
    icon: 'fas fa-window-minimize'
  }, {
    icon: 'fas fa-window-restore'
  }, {
    icon: 'fas fa-wine-bottle'
  }, {
    icon: 'fas fa-wine-glass'
  }, {
    icon: 'fas fa-wine-glass-alt'
  }, {
    icon: 'fas fa-won-sign'
  }, {
    icon: 'fas fa-wrench'
  }, {
    icon: 'fas fa-x-ray'
  }, {
    icon: 'fas fa-yen-sign'
  }, {
    icon: 'fas fa-yin-yang'
  }, {
    icon: 'fas fa-'
  }];
  var itemTemplate = $('.icon-picker-list').clone(true).html();
  $('.icon-picker-list').html(''); // Loop through JSON and appends content to show icons

  $(icons).each(function (index) {
    var itemtemp = itemTemplate;
    var item = icons[index].icon;

    if (index == selectedIcon) {
      var activeState = 'active';
    } else {
      var activeState = '';
    }

    itemtemp = itemtemp.replace(/{item}/g, item).replace(/{index}/g, index).replace(/{activeState}/g, activeState);
    $('.icon-picker-list').append(itemtemp);
  }); // Variable that's passed around for active states of icons

  var selectedIcon = null;
  $('.icon-class-input').each(function () {
    if ($(this).val() != null) {
      $(this).siblings('.demo-icon').addClass($(this).val());
    }
  }); // To be set to which input needs updating

  var iconInput = null; // Click function to set which input is being used

  $('.picker-button').click(function () {
    // Sets var to which input is being updated
    iconInput = $(this).siblings('.icon-picker'); // Shows Bootstrap Modal

    $('#iconModal').modal('show'); // Sets active state by looping through the list with the previous class from the picker input

    selectedIcon = findInObject(icons, 'icon', $(this).siblings('.icon-picker').val()); // Removes any previous active class

    $('.icon-picker-list a').removeClass('active'); // Sets active class

    $('.icon-picker-list a').eq(selectedIcon).addClass('active');
  }); // Click function to select icon

  $(document).on('click', '.icon-picker-list a', function () {
    // Sets selected icon
    selectedIcon = $(this).data('index'); // Removes any previous active class

    $('.icon-picker-list a').removeClass('active'); // Sets active class

    $('.icon-picker-list a').eq(selectedIcon).addClass('active');
  }); // Update icon input

  $('#change-icon').click(function () {
    iconInput.val(icons[selectedIcon].icon);
    iconInput.siblings('.demo-icon').attr('class', 'demo-icon');
    iconInput.siblings('.demo-icon').addClass(icons[selectedIcon].icon);
    $('#iconModal').modal('hide');
    console.log(iconInput);
    console.log(icons[selectedIcon].icon);
  });
  $("#icon-filter").on("keyup", function () {
    var value = $(this).val().toLowerCase();
    $(".icon-list-item").filter(function () {
      $(this).toggle($(this).find('.name-class').text().toLowerCase().indexOf(value) > -1);
    });
  }); //icon functions

  function findInObject(object, property, value) {
    for (var i = 0; i < object.length; i += 1) {
      if (object[i][property] === value) {
        return i;
      }
    }
  }

  $('.icon-close').click(function () {
    $('#iconModal').modal('hide');
  });
});

/***/ }),

/***/ "./resources/js/teacherfunctions.js":
/*!******************************************!*\
  !*** ./resources/js/teacherfunctions.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

//collapse skills
$(document).on('click', '#collapse-skills', function () {
  if ($('#collapse-skills-icon').attr('class').includes('compress')) {
    $('#edit-skills').hide();
    $('#collapse-skills-icon').attr('class', 'fas fa-expand-arrows-alt');
  } else {
    $('#edit-skills').show();
    $('#collapse-skills-icon').attr('class', 'fas fa-compress-arrows-alt');
  }
}); //Add new VM Skill

$(document).on('click', '#add-new-skill', function () {
  modeltype = $('#type-header').data('model-type');
  name = $('#edit-vm-name').text();
  skill = $('#new-skill').val();
  $.post('/api/teacher/create/vmskill/' + name, {
    skill: skill
  }, function (data) {
    window.getModelInfo(modeltype, name);
  });
}); //Delete VM Skill

$(document).on('click', '.delete-skill', function () {
  modeltype = $('#type-header').data('model-type');
  name = $('#edit-vm-name').text();
  skill = $('#new-skill').val();
  skillId = $(this).attr('id').split('-')[2];
  $.post('/api/teacher/delete/vmskill/' + name, {
    id: skillId
  }, function () {
    window.getModelInfo(modeltype, name);
  });
}); //OVA Upload

$(document).on('show.bs.modal', '#uploadOvaModal', function (event) {
  var button = $(event.relatedTarget);
  var name = window.convertName(button.data('name'));
  $('#ova-file').attr('onchange', 'window.selectorScript(\'http://www.ocl.dev/api/teacher/upload/chunkupload\',\'' + name + '\')');
}); //manage vm Modal

$(document).on('click', '.vmmanage-modal', function (event) {
  var button = $(this);
  var name = button.data('name');
  var modal = $('#vmManageModal');
  modal.modal('show');
  modal.find('.modal-title').text('Manage ' + name + ' Virtual Machine');
  modal.data('name', name);
  $.get('/api/teacher/get/vbox/interfaces', function (data) {
    $('#vm-bridged-adapter').empty();

    for (i = 0; i < data.length; i++) {
      $('#vm-bridged-adapter').append('<option value=' + data[i] + '>' + data[i] + '</option.');
    }
  });
  updateVMManage(name);
}); //Change VM Network Mode

$(document).on('click', '#modify-network-mode', function () {
  var name = $('#vmManageModal').data('name');
  var mode = $('#vm-network-mode').val();
  $.post('/api/teacher/set/vbox/network/' + window.convertName(name), {
    'vm-network-mode': mode
  }, function (data) {
    alert(data['message']);
    updateVMManage(name);
  });
}); //Change VM Bridged Adapter

$(document).on('click', '#modify-bridged-adapter', function () {
  var name = $('#vmManageModal').data('name');
  var device = $('#vm-bridged-adapter').val();
  $.post('/api/teacher/set/vbox/bridged/' + window.convertName(name), {
    'vm-bridged-adapter': device
  }, function (data) {
    alert(data['message']);
    updateVMManage(name);
  });
});

function updateVMManage(name) {
  $.get('/api/teacher/get/vbox/vminfo/' + window.convertName(name), function (data) {
    makeStatus(data['status']);

    if (data['registered']) {
      $('#vm-register-state').text('Machine is Registered.');
      $('#register-vm').hide();
      $('#unregister-vm').show();
      $('#vm-network-table').show();
      $('#vm-power').show();

      if (data['NIC 1'].includes('Bridged')) {
        $('#vm-network-mode').val('Bridged');
        $('.vm-bridged').show();
        $('#vm-bridged-adapter').val(data['NIC 1'].split('\'')[1]);
      } else if (data['NIC 1'].includes('NAT')) {
        $('#vm-network-mode').val('NAT');
        $('.vm-bridged').hide();
      }
    } else {
      $('#vm-register-state').text('Machine is not yet registered.');
      $('#unregister-vm').hide();
      $('#register-vm').show();
      $('#vm-network-table').hide();
      $('#vm-power').hide();
    }
  });
}

window.getModelInfo = function (modeltype, name) {
  var page = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 0;

  if (!modeltype.includes('hints')) {
    var baseAction = $('#edit-' + modeltype).attr('action');
    baseAction = '/' + baseAction.split("/")[1] + '/' + baseAction.split("/")[2] + '/' + baseAction.split("/")[3] + '/';
    $('#edit-' + modeltype).attr('action', baseAction + name);
  }

  var url = '/api/teacher/get/' + modeltype + '/' + name;
  var output;
  $.get(url, {
    'page': page
  }, function (data) {
    if (!modeltype.includes('hints')) {
      window.updateModelView(modeltype, data);
    } else if (modeltype.includes('b2r')) {
      window.updateB2RHintModal(data, name);
    } else if (modeltype.includes('lab')) {
      $('#add-new-hint-form').attr('data-levels', data['levels']);
      window.updateLabHintModal(data['hints'], name, data['levels']);
    }
  });
};

window.updateModelView = function (modeltype, ajaxdata) {
  if (modeltype == 'b2r' || modeltype == 'lab') {
    vm = ajaxdata[modeltype];
    $('#edit-vm-name').text(vm['name']);
    $('#edit-pts').val(vm['points']);
    $('#edit-ip').val(vm['ip']);
    $('#edit-file-name').text(vm['file']);
    $('#edit-os-select').val(vm['os']);
    $('#edit-icon-picker').val(vm['icon']);
    $('#edit-description').val(vm['description']);

    if (modeltype == 'b2r') {
      $('#edit-root-flag').val(vm['flags']['root_flag']);
      $('#edit-user-flag').val(vm['flags']['user_flag']);
    }

    if (modeltype == 'lab') {
      window.clearLevelFlags();
      var flags = ajaxdata[modeltype]['flags'];
      flags.forEach(function (item, index, array) {
        window.makeLevelLineItem(item['level'], item['id'], index == array.length - 1);
        $('#level-flag-' + item['level']).val(item['flag']);
      });
    } //make and update skill items for vm


    window.makeSkillLineItems(ajaxdata[modeltype]['skills']);
    window.updateSkillItems(ajaxdata[modeltype]['skills']);
  }
};

window.updateB2RHintModal = function (ajaxdata, name) {
  levels = 0;
  ajaxdata.forEach(function (item, index) {
    window.makeHintRow(item, index, 'b2r', levels);
    window.populateHintRow(item, 'b2r', index);
  });
};

window.updateLabHintModal = function (ajaxdata, name, levels) {
  $('#edit-hints-table').empty();
  window.makePagination(ajaxdata['last_page']);
  data = ajaxdata['data'];
  currentPage = ajaxdata['current_page']; //set current page for refresh

  $('#hint-page-nav').attr('data-current', currentPage);
  data.forEach(function (item, index) {
    window.makeHintRow(item, index, 'lab', levels);
    window.populateHintRow(item, 'lab', index);
  });
  $('#hint-page-' + currentPage).attr('class', 'page-item active');
};

window.updateLevelItem = function (item, index) {
  window.makeLevelLineItem(item['level'], item['id']);
  $('#level-flag-' + item['level']).val(item['flag']);
};

window.clearLevelFlags = function () {
  $('#level-flags-body').empty();
};

window.makeLevelLineItem = function (level, id) {
  var lastElement = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;
  idLabel = 'level-flag-' + level;
  html = '<tr><td><label for="' + idLabel + '" class="my-1">Level ' + level + ' Flag</label>\n';
  html = html + '<input type="text" class="form-control" id="' + idLabel + '" name="flag-' + level + '"></td>\n';

  if (lastElement) {
    html = html + '<td><button type="button" class="btn btn-primary my-4 delete-level" data-id="' + id + '"><i class="fas fa-trash-alt"></i></button></td></tr>';
  } else {
    html = html + '<td></td></tr>';
  }

  $('#level-flags-body').append(html);
};

window.updateSkillLineItem = function () {};

window.makeSkillLineItems = function (data) {
  $('#skills-body').empty();
  skillSelect = makeSkillsList();

  for (i = 1; i <= data.length; i++) {
    html = '<tr><td><label class="my-2">Skill #' + i + '</label>\n';
    html = html + '<select name="skill-' + data[i - 1]['id'] + '" id="skill-' + data[i - 1]['id'] + '" class="form-control mx-1">\n';
    html = html + skillSelect;
    html = html + '</select></td><td class="align-bottom">\n<button type="button" class="mx-2 btn btn-primary delete-skill" id="delete-skill-' + data[i - 1]['id'] + '"><i class="fas fa-trash-alt"></i></button>\n</td>\n</tr>';
    $('#skills-body').append(html);
  }

  html = '<tr><td ><label class="my-2">Add New Skill</label>\n<select name="new-skill" id="new-skill" class="form-control mx-1">\n';
  html = html + skillSelect;
  html = html + '</select></td>\n<td class="align-bottom">\n<button type="button" class="mx-2 btn btn-primary align-middle" id="add-new-skill"><i class="fas fa-plus"></i></button>\n</td>\n</tr>';
  $('#skills-body').append(html);
};

window.updateSkillItems = function (data) {
  data.forEach(function (item, index) {
    $('#skill-' + item['id']).val(item['skill']);
  });
};

window.convertName = function (name) {
  return name.toLowerCase().replace(/ /g, '_');
};

function makeSkillsList() {
  $.ajax({
    url: '/api/teacher/get/skills',
    success: function success(data) {
      skills = data;
    },
    async: false
  });
  html = '';
  skills.forEach(function (item, index) {
    html = html + '<option value="' + item['name'] + '">' + item['name'] + '</option>\n';
  });
  return html;
}

function makeSpinner(divId) {
  $('#' + divId).empty();
  spinner = '<div class="spinner-border text-primary" role="status"><span class="sr-only"></span></div>';
  $('#' + divId).append(spinner);
}

1;

function makeStatus(status) {
  $('#vm-status').empty();

  if (status) {
    $('#vm-status').append('<i class="fas fa-power-off fa-2x text-primary"></i>');
  } else {
    $('#vm-status').append('<i class="fas fa-power-off  fa-2x text-danger"></i>');
  }
}

/***/ }),

/***/ 1:
/*!***************************************!*\
  !*** multi ./resources/js/teacher.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/devel/ocl/resources/js/teacher.js */"./resources/js/teacher.js");


/***/ })

/******/ });