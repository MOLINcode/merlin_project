/**
 * @author Mike Cao ( GoodLoser )
 * @date 09/23/2014
 */

(function(w, $){
	"use strict";
	
	var ImageFile = function(file){
    	this.key = iUploader.Util.generateKey(file);
    	this.File = file;
    };
    
    var iUploader = {
    		imageWidth : 160,
    		maxAllowedSize : 5*1024*1024,
    		currentSize : 0,
    		
    		selectedFiles : [],
    		
    		cleanMainView : function(){
    			$(".iupload-main-view").children(".iupload-thumbnail").remove();
    			this.hideImgPicker();
    		},
    		drawMainView : function(files){
    			$.each(files, function(i, file){
    				if(!iUploader.Util.isImage(file)){
    	        		return;
    	        	}
    				if(w.webkitURL || w.URL){
    					iUploader.Util.createThumbnailByCreateObjectURL(file);
    				}else if(FileReader){
    					iUploader.Util.createThumbnailByFileReader(file);
    				}
    			});
    		},
    		fileSelected : function(files, onSelected){
    			var file_lists = files;
    	        this.cleanMainView();
    	        $.each(file_lists, function(i, file){
    	        	if(!iUploader.Util.isImage(file)){
    	        		return;
    	        	}
    	        	iUploader.currentSize += file.size;
    	        	if(iUploader.currentSize>iUploader.maxAllowedSize){
    	        		alert("Image size exceeds the maximum allowed value.");
    	        		iUploader.currentSize -= file.size;
    		        	return false;
    	        	}
    	        	//name_type_size as a unique key
    	        	var ifile = new ImageFile(file);
    	        	if(iUploader.Util.contains(iUploader.selectedFiles, ifile)){
    	        		iUploader.Util.remove(iUploader.selectedFiles, ifile.key);
    	        	}
    	        	iUploader.selectedFiles.push(ifile);
    	        });
    	        this.showControlBar();
    	        this.drawMainView(this.selectedFiles);
	        	
    	        if(onSelected) onSelected.call(w, files);
    		},
    		deleteFile : function(fileKey){
    			this.Util.remove(this.selectedFiles, fileKey);
    			var thumbnail = $("#iupload_"+fileKey);
    			var size = parseInt(thumbnail.data("size"));
    			this.currentSize -= size;
    			thumbnail.remove();
    	        if(this.Util.length(this.selectedFiles) == 0){
    	        	this.showImgPicker();
    	        	this.hideControlBar();
    	        }else{
    		        this.showControlBar();
    	        }
    		},
    		upload : function(	url,/* upload URL*/
    							formDatas,/*object*/ 
    							onStart,/*call back function*/
    							onProgress,/*call back function*/
    							onError,/*call back function*/
    							onSingleFileDone,/*call back function*/
    							onAllFilesDone,
    							autoDelete){
    			
    	        $.each(this.selectedFiles, function(i, file/**ImageFile*/){
    	            if(!iUploader.Util.isImage(file)){
    	                return;
    	            }
    	            var formData = new FormData();
    	            formData.append("image" + i, file.File);
    	            
    	            if(formDatas && typeof formDatas === 'object'){
    	            	for(var attr in formDatas){
    	            		formData.append(attr, formDatas[attr]);
    	            	}
    	            }
    	            
    	            var xhr = new XMLHttpRequest();

    	            xhr.upload.addEventListener("progress", function(e){
    	            	if(e.lengthComputable){
    	            		var $pbar = $("#iupload_" + file.key + " .iupload-progressbar");
    	            		var wdth = ((e.loaded * 100)/(e.total)).toFixed(1) + "%";
    	            		$pbar.width(wdth);
    	            	}
    	            	e.file = file;
    	            	if(onProgress) onProgress.call(w, e);
    	            }, false);
    	            
    	            xhr.addEventListener("loadstart", function(e){
    	            	$("#iupload_" + file.key + " .iupload-image-foot").show();
    	            	if(onStart) onStart.call(w, file);
    	            }, false);
    	            
    	            xhr.addEventListener("load", function(e){
    	            	if(this.status == 200){
    	            		if(autoDelete) iUploader.deleteFile(file.key);
    	            		else iUploader.Util.remove(iUploader.selectedFiles, file.key);//remove from the queue
    	            		e.file = file;
    	            		if(onSingleFileDone) onSingleFileDone.call(w, e);
    	            		if(!(iUploader.Util.length(iUploader.selectedFiles))){
    	            			if(onAllFilesDone) onAllFilesDone.call(w, iUploader.selectedFiles);
    	            		}
    	            	}
    	            }, false);
    	            
    	            xhr.addEventListener("error", function(e){
    	            	if(onError) onError.apply(w, file);
    	            }, false);
    	            
    	            xhr.open("POST", url, true);
    	            xhr.send(formData);
    	        });
    	    },
            calImageWidth : function(columns){
            	var uploaderWidth = $(".iupload-main-view").width();
            	var scrollWidth = 20;
            	uploaderWidth = uploaderWidth - scrollWidth;
            	if(columns < 3)columns = 3;
            	var marginWidth = 18;
            	this.imageWidth = uploaderWidth / columns - marginWidth;
            },
            
            setMaxAllowedSize : function(max){
            	this.maxAllowedSize = max;
            },
            
            showControlBar: function(){
            	$(".iupload-controlBar").show();
            },
            hideControlBar: function(){
            	$(".iupload-controlBar").hide();
            },
            hideImgPicker : function(){
            	$(".iupload-imgpicker").hide();
    		},
    		showImgPicker : function(){
    			$(".iupload-imgpicker").show();
    		}
    };
    
    iUploader.UI = {
    		controlBar : "<div class=\"iupload-row iupload-controlBar\">" +
							"<div class=\"iupload-col iupload-col-12\">" +
								"<i class=\"iconfont icon-addimage\" style=\"position: relative;\">" +
									"<input class=\"iupload-fileinput\" type=\"file\" name=\"files\" multiple>" +
								"</i>" +
								"<i class=\"iconfont icon-upload\"></i>" +
							"</div>" +
						"</div>",
			mainView : "<div class=\"iupload-row\">" +
							"<div class=\"iupload-col iupload-col-12 iupload-bordered iupload-main-view\">" +
								"<i class=\"iconfont icon-addimage iupload-centered iupload-imgpicker\">" +
									"<input class=\"iupload-fileinput\" type=\"file\" name=\"files\" multiple>" +
								"</i>" +
							"</div>" +
						"</div>",
			
			thumbnail : "<div  class=\"iupload-thumbnail\">" +
							"<div class=\"iupload-image-head\"><i class=\"iconfont icon-delete iconfont-small\"></i></div>" +
							"<div class=\"iupload-image-foot\">" +
								"<span class=\"iupload-progressbar\">&nbsp;</span>" +
							"</div>" +
						"</div>",
			
    };
    
    iUploader.Util = {
    		specialChars : /[(\ )(\~)(\!)(\@)(\#)(\$)(\%)(\^)(\&)(\*)(\()(\))(\-)(\_)(\+)(\=)(\[)(\])(\{)(\})(\|)(\\)(\;)(\:)(\')(\")(\,)(\.)(\/)(\<)(\>)(\?)(\)(\`)]/g,
	    	generateKey : function(file){
	    		return (file.name+"_"+file.type+"_"+file.size).replace(this.specialChars, "");
	    	},    
	    	contains : function(files, file){
	    		if(!file || !file instanceof ImageFile){
	    			return false;
	    		}
	    		for(var i = 0; i < files.length; i++){
	    			if(!files[i] || !files[i].key) continue;
	    			if(file.key === files[i].key) return true;
	    		}
	    		return false;
	    	},
	    	remove : function(files, key){
	    		for(var i = 0; i < files.length; i++){
	                if(!files[i] || !files[i] instanceof ImageFile){
	                	continue;
	                }
	                if(files[i].key === key){
	                	files[i] = null;
	                }
	            }
	    	},
	        isImage : function(file/**File or ImageFile*/){
	        	if(!file) return false;
	        	
	        	if(file instanceof ImageFile 
	        			&& file.File 
	        			&& file.File instanceof File 
	        			&& /image\/.*/g.test(file.File.type))
	        	return true;
	        	
	        	if(file instanceof File && /image\/.*/g.test(file.type)){
	        		return true;
	        	}
	        	
	        	return false;
	        },
	        length : function(files){
	        	var count = 0;
	        	for(var i = 0; i < files.length; i++){
	        		if(this.isImage(files[i])){
	        			count++;
	        		}
	        	}
	        	return count;
	        },
	        /** return a string include B, KB, MB represent a legible size*/
	        legibleSize :function(files){
	        	var size = 0;
	        	for(var i = 0; i < files.length; i++){
	        		if(this.isImage(files[i]) && files[i].File){
	        			size += files[i].File.size;
	        		}
	        	}
	        	return this.readSize(size);
	        },
	        readSize : function(oriSize){
	        	if(oriSize < 1024){
	        		return oriSize + " B";
	        	}else if (oriSize < 1024 * 1024){
	        		return (oriSize / 1024).toFixed(2) + " KB";
	        	}else{
	        		return (oriSize / (1024*1024)).toFixed(2) +" MB";
	        	};
	        },
	        hTML5Support : function(){
//	        	fileReaderSupport();
//	        	ajaxUploadSupport();
//	        	formDataSupport();
	        },
	        createThumbnailByFileReader : function(file){
	        	var reader = new FileReader();
	            reader.onload = function(e){
	            	var thumbnail = $(iUploader.UI.thumbnail);
	            	thumbnail.attr("id", "iupload_" + file.key);
	            	thumbnail.data("size", file.File.size);
	            	var canvas = w.document.createElement('canvas');
	            	var img = new Image();
	            	img.src = e.target.result;
	            	canvas.width = iUploader.imageWidth;
	            	canvas.getContext("2d").drawImage
	            	    (img, 0, 0, canvas.width, canvas.height)
	            	thumbnail.append(canvas);
	                $(".iupload-main-view").append(thumbnail);
	            };
	            reader.readAsDataURL(file.File);
	        },
	        createThumbnailByCreateObjectURL : function(file){
	        	var thumbnail = $(iUploader.UI.thumbnail);
            	thumbnail.attr("id", "iupload_" + file.key);
            	thumbnail.data("size", file.File.size);
            	var img = new Image();
            	img.width = iUploader.imageWidth;
            	w.URL = w.webkitURL || w.URL;
            	var canvas = w.document.createElement('canvas');
            	canvas.width = iUploader.imageWidth;
            	img.onload = function(e) {
                	canvas.getContext("2d").drawImage
                	    (img, 0, 0, canvas.width, canvas.height)
            	    w.URL.revokeObjectURL(img.src); // Clean up after yourself.
            	};
            	img.src = w.URL.createObjectURL(file.File);
            	thumbnail.append(canvas);
                $(".iupload-main-view").append(thumbnail);
	        }
    };
    
    iUploader.API = {
    		//compatible check
    		//FileReader
    		//XMLHttpRequest
    		//XMLHttpRequest.upload
    		
    		init : function(options){
				var $this = $(this);
				$this.children().remove();
				$this.addClass("iupload-container");
				var default_settings = {//default settings.
					URL : "uploadController.do?method=upload",
					Multiple : true,//
					ColumnsNum : 5,//default
					MaxSize : 5*1024*1024,//default as 5MB
					FormDatas : {},
					AutoDelete : false,
					OnSelected: function(files){},//[ImageFile, ImageFile]
	    			OnStart: function(file){},//ImageFile
	    			OnProgress: function(e){},//{lengthComputable, loaded, total, file} - progress file
	    			OnError: function(file){},
	    			OnSingleFileSuccess : function(e){},//{load, file}
	    			OnAllFilesDone : function(files){}
				};
				var settings = $.extend(default_settings, options);
				
				$this.append($(iUploader.UI.controlBar));
				$this.append($(iUploader.UI.mainView));
				
				iUploader.showImgPicker();
				iUploader.hideControlBar();

				$(".iupload-fileinput").attr("multiple", settings.Multiple);
				
				iUploader.calImageWidth(settings.ColumnsNum);
				iUploader.setMaxAllowedSize(settings.MaxSize);
				
				$(".iupload-fileinput").change(function(){
					var files = this.files;
					iUploader.fileSelected(files, settings.OnSelected);
				});
				
			    $(w.document).on("mouseenter", ".iupload-thumbnail", function(event){
			    	$(this).children(".iupload-image-head").fadeIn();
			    }).on("mouseleave", ".iupload-thumbnail", function(event){
			    	$(this).children(".iupload-image-foot").fadeOut();
			    });
			    
			    $(w.document).on("click", ".icon-delete", function(event){
			        var fileKey = $(this).parent().parent().attr("id").replace("iupload_", "");
			        iUploader.deleteFile(fileKey);
			    });
			   
			    $(".icon-upload").click(function(){
			    	iUploader.upload(settings.URL, settings.FormDatas, 
			    			settings.OnStart, settings.OnProgress, settings.OnError,
			    			settings.OnSingleFileSuccess, settings.OnAllFilesDone, settings.AutoDelete);
			    });
			}
    }
    
	/**
	 * Extends jQuery object.
	 * ***/
	$.fn.iUploader = function(options){
		if(typeof options === "string"){
			
		}else if(typeof options === "object"){
			iUploader.API.init.apply(this, arguments);
		}
	};
	
    
})(window, jQuery);