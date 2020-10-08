!function(t){var e={};function n(a){if(e[a])return e[a].exports;var o=e[a]={i:a,l:!1,exports:{}};return t[a].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=t,n.c=e,n.d=function(t,e,a){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:a})},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var a=Object.create(null);if(n.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var o in t)n.d(a,o,function(e){return t[e]}.bind(null,o));return a},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="/",n(n.s=55)}({55:function(t,e,n){t.exports=n(56)},56:function(t,e){$(document).on("click",".edit-assignment",(function(){var t=$(this).data("id"),e=$(this).data("prefix").toLowerCase();!function(t,e){$("#edit-container").empty(),html='<form>\n<label for="model-select">Assign Resource</label> \t\t<select class="form-control" name="model-select" id="edit-model-select"></select>\n',"b2r"==t?html+='<label for="flag-select" class="my-2">Flags Required</label>\n \t\t<select class="form-control" name="flag-select" id="flag-select">\n \t\t\t<option value="both">User and Root</option>\n \t\t\t<option value="root">Root Only</option>\n \t\t\t<option value="user">User Only</option>\n \t\t</select>\n':"lab"==t&&(html+='<div class="container d-flex justify-content-between my-3">\n \t\t\t\t\t\t<label for="start-flag">Starting Flag</label>\n \t\t\t\t\t\t<input type="number" class="form-control mx-3" name="start-flag" id="start-flag">\n \t\t\t\t\t\t<label for="end-flag">Ending Flag</label>\n \t\t\t\t\t\t<input type="number" class="form-control mx-3" name="end-flag" id="end-flag">\n \t\t\t\t\t</div>');html=html+'<button type="button" class="btn btn-primary my-2" id="edit-assignment" data-id="'+e+'"><i class="fas fa-save"></i></button>\n \t \t\t\t <button type="button" class="btn btn-primary my-2" id="delete-assignment" data-id="'+e+'"><i class="fas fa-trash-alt"></i></button>\n \t\t</form>',$("#edit-container").append(html)}(e,t),$.ajax({url:"/teacher/get/all/"+e,type:"get",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},success:function(n){!function(t,e,n){for(i=0;i<t.length;i++)$("#edit-model-select").append('<option value="'+t[i]+'">'+t[i]+"</option>");$.ajax({url:"/teacher/get/assignment/modelname/"+n,type:"get",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},success:function(t){$("#edit-model-select").val(t.name)},error:function(t){console.log(t)}}),"lab"==e&&$.ajax({url:"/teacher/get/assignment/levels/"+n,type:"get",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},success:function(t){$("#start-flag").val(t.start),$("#end-flag").val(t.end)},error:function(t){console.log(t)}})}(n,e,t)},error:function(t){console.log(t)}})})),$(document).on("click","#edit-assignment",(function(){var t=$(this).data("id"),e=$("#edit-container").find(":input"),n={};for(i=0;i<e.length-2;i++){var a=$(e[i]).attr("id"),o=$(e[i]).val();n[a]=o}$.ajax({url:"/teacher/update/assignment/"+t,type:"post",data:n,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},success:function(t){},error:function(t){console.log(t)}})})),$(document).on("click","#delete-assignment",(function(){var t=$(this).data("id");$.ajax({url:"/teacher/delete/assignment/"+t,type:"post",data:postData,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},success:function(t){location.reload()},error:function(t){console.log(t)}})})),$(document).on("change","#student-select",(function(){var t=$(this).val();$.ajax({url:"/teacher/get/student/"+t+"/assignments/completed",type:"get",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},success:function(t){!function(t){for($("#completed-assignments").empty(),i=0;i<t.length;i++){var e=t[i].prefix.toLowerCase(),n=t[i][e];"lab"==e?html="<p>"+t[i].prefix+": "+n[e+"_name"]+" Levels:"+n.start_level+"-"+n.end_level+"</p>":"b2r"==e?(flag="",1==n.user&&(flag+="|user"),1==n.root&&(flag+=" |root"),flag+="|",html="<p>"+t[i].prefix+": "+n[e+"_name"]+"\r\n Flag(s):"+flag+"</p>"):html="<p>"+t[i].prefix+": "+n[e+"_name"]+"</p>",$("#completed-assignments").append(html)}}(t)},error:function(t){console.log(t)}}),$.ajax({url:"/teacher/get/student/"+t+"/assignments/incomplete",type:"get",headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},success:function(t){!function(t){for($("#incomplete-assignments").empty(),i=0;i<t.length;i++){var e=t[i].prefix.toLowerCase(),n=t[i][e];"lab"==e?html="<p>"+t[i].prefix+": "+n[e+"_name"]+" Levels:"+n.start_level+"-"+n.end_level+"</p>":"b2r"==e?(flag="",1==n.user&&(flag+="|user"),1==n.root&&(flag+=" |root"),flag+="|",html="<p>"+t[i].prefix+": "+n[e+"_name"]+"\r\n Flag(s):"+flag+"</p>"):html="<p>"+t[i].prefix+": "+n[e+"_name"]+"</p>",$("#incomplete-assignments").append(html)}}(t)},error:function(t){console.log(t)}})}))}});