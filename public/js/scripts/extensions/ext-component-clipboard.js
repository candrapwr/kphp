"use strict";var userText=$("#copy-to-clipboard-input"),btnCopy=$("#btn-copy"),isRtl="rtl"===$("html").attr("data-textdirection");btnCopy.on("click",(function(){userText.select(),document.execCommand("copy"),toastr.success("","Copied to clipboard!",{rtl:isRtl})}));
