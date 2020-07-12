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

/***/ "./resources/js/teacher/chunkupload.js":
/*!*********************************************!*\
  !*** ./resources/js/teacher/chunkupload.js ***!
  \*********************************************/
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

/***/ "./resources/js/teacher/createvm.js":
/*!******************************************!*\
  !*** ./resources/js/teacher/createvm.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {});

/***/ }),

/***/ "./resources/js/teacher/teacheredithints.js":
/*!**************************************************!*\
  !*** ./resources/js/teacher/teacheredithints.js ***!
  \**************************************************/
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

/***/ "./resources/js/teacher/teacherresource.js":
/*!*************************************************!*\
  !*** ./resources/js/teacher/teacherresource.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ./chunkupload */ "./resources/js/teacher/chunkupload.js");

__webpack_require__(/*! ./teacherresourcefunctions */ "./resources/js/teacher/teacherresourcefunctions.js");

__webpack_require__(/*! ./createvm */ "./resources/js/teacher/createvm.js");

__webpack_require__(/*! ./teacheredithints */ "./resources/js/teacher/teacheredithints.js");

/***/ }),

/***/ "./resources/js/teacher/teacherresourcefunctions.js":
/*!**********************************************************!*\
  !*** ./resources/js/teacher/teacherresourcefunctions.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

//--------------------------Delete Model JQUERY--------------------------------//
$(document).on('click', '.delete-model', function () {
  var name = $(this).data('name');
  var type = $(this).data('type');
  $.post('/api/teacher/delete/' + type + '/' + name, function (data) {
    location.reload();
  });
}); //--------------------------Skills JQUERY--------------------------------//
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
}); //--------------------------OVA JQUERY--------------------------------//
//OVA Upload

$(document).on('show.bs.modal', '#uploadOvaModal', function (event) {
  var button = $(event.relatedTarget);
  var name = window.convertName(button.data('name'));
  $('#ova-file').attr('onchange', 'window.selectorScript(\'http://www.ocl.dev/api/teacher/upload/chunkupload\',\'' + name + '\')');
}); //OVA Delete

$(document).on('click', '#delete-ova', function () {
  var name = window.convertName($('#edit-vm-name').text());
  $.post('/api/teacher/delete/vm/file/' + name, function (data) {
    console.log(data);
    $('#edit-file-name').text('');
  }).fail(function (data) {
    console.log(data);
  });
}); //--------------------------VM Management JQUERY----------------------//
//manage vm Modal

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
}); //Reload page for status changes on management close.

$(document).on('hide.bs.modal', '#vmManageModal', function () {
  location.reload();
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
}); //Toggle Power Button

$(document).on('click', '#vm-power-toggle', function () {
  var name = $('#vmManageModal').data('name'); //set status to indicate awaiting repsonse

  makeSpinner('vm-status');
  $.post('/api/teacher/set/vbox/power/' + window.convertName(name), function (data) {
    makeStatus(data['status']);
  }).fail(function (data) {
    json = data['responseJSON'];
    makeStatus(json['status']);
  });
}); //Reset Button

$(document).on('click', '#vm-reset', function () {
  var name = $('#vmManageModal').data('name'); //set status to indicate awaiting repsonse

  makeSpinner('vm-status');
  $.post('/api/teacher/set/vbox/reset/' + window.convertName(name), function (data) {
    console.log(data);
    makeStatus(data['status']);
  }).fail(function (data) {
    json = data['responseJSON'];
    makeStatus(json['status']);
  });
}); //Unregister Button

$(document).on('click', '#unregister-vm', function () {
  var name = $('#vmManageModal').data('name');
  $.post('/api/teacher/set/vbox/unregister/' + window.convertName(name), function (data) {
    alert(data['message']);
    location.reload();
  }).fail(function (data) {
    json = data['responseJSON'];
    alert(json['message']);
    location.reload();
  });
}); //Register Button

$(document).on('click', '#register-vm', function () {
  var name = $('#vmManageModal').data('name');
  $.post('/api/teacher/set/vbox/register/' + window.convertName(name), function (data) {
    location.reload();
  }).fail(function (data) {
    console.log(data);
  });
}); //--------------------------Functions-------------------------------//

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

function makeSpinner(id) {
  $('#' + id).empty();
  spinner = '<div class="spinner-border text-primary" role="status"><span class="sr-only"></span></div>';
  $('#' + id).append(spinner);
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
/*!*******************************************************!*\
  !*** multi ./resources/js/teacher/teacherresource.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/html/devel/ocl/resources/js/teacher/teacherresource.js */"./resources/js/teacher/teacherresource.js");


/***/ })

/******/ });