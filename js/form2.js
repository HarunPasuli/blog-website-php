'use strict';

$('#file-upload').change(function() {
    var fileName = $(this).val().split('\\').pop();
    $('.file-upload-text').html(fileName);
  });
  
  function getFileData() {
    const fileInput = document.getElementById('file-upload');
    const fileName = fileInput.files[0].name;
    const previewDiv = document.querySelector('.file-name-preview');
    previewDiv.textContent = "File name: " + fileName;
  }

  
  function getFileData2() {
    const fileInput2 = document.getElementById('file-profile-picture');
    const fileName2 = fileInput2.files[0].name;
    const previewDiv2 = document.querySelector('.profile-picture-preview');
    previewDiv2.textContent = "File name: " + fileName2;
  }
  