//What is required: token, sha256sum of file name, file, filesize, chunksize, total chunks, url (reuse)

window.chunkUpload = class {
	constructor(url, chunk_size){
		this.request_limit = 1000;
		this.url = url;
		this.api_token = document.querySelector( '.api_token' ).value;
		this.file = document.querySelector( '.ova' ).files[0];
		this.reader = new FileReader();

		if(this.getTotalChunks(chunk_size*1024) > this.request_limit){
			this.chunk_size = this.getChunkSize()*1024;
		}else{
			this.chunk_size = chunk_size*1024;
		}
		this.curr_chunk = 0;
		this.total_chunks = this.getTotalChunks(this.chunk_size);
		this.final = false;
	}

	//Calculates the chunk size based on file size and api request limit (1000)
	getChunkSize(){
		//console.log("Calculating total chunk size", Math.ceil(this.file.size/(this.request_limit*1024)));
		return Math.ceil(this.file.size/(this.request_limit*1024));
	}

	getTotalChunks(size){
		//console.log("Calculating total chunks", Math.ceil(this.file.size/size));
		return Math.ceil(this.file.size/size);
	}

	upload_file( start, obj) {
   		var next_slice = start + obj.chunk_size + 1;
    	var blob = obj.file.slice( start, next_slice );
    	var final = false;
    	
    	this.reader.onloadend = function( event ) {
    	if ( event.target.readyState !== FileReader.DONE ) {
        	return;
    	}
    	
    	if(obj.curr_chunk == obj.total_chunks-1 ){
    		final = true;
    		document.getElementById('submit').disabled = false;
    	}

		$.ajax( {
          	 	url: obj.url,
            	type: 'POST',
            	dataType: 'text',
            	cache: false,
            	data: {
                api_token: obj.api_token,
                file_data: event.target.result,
                file: obj.file.name,
                file_type: obj.file.type,
                final_chunk: final,
            },
            error: function( jqXHR, textStatus, errorThrown ) {
                console.log( jqXHR, textStatus, errorThrown );
            },
            success: function( data ) {
            	obj.curr_chunk++;
            	var percentage = Math.floor((obj.curr_chunk/obj.total_chunks)*100);
            	var updateString = 'Percentage done: ',percentage;
                document.getElementById('percent').innerHTML = 'Percentage uploaded: '+percentage+'%';
                if(!final){
               	 	document.getElementById('submit').disabled=true;
               	}
                if ( next_slice < obj.file.size ) {
                	obj.upload_file( next_slice, obj);	
                } 
            }
        } );
    };

    this.reader.readAsDataURL( blob );
}

}

window.selectorScript = function(url){
	const p = new window.chunkUpload(url, 10000);
	p.upload_file(0, p);
}