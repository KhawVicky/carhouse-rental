const customFileInputs = document.querySelectorAll('.custom-file-input');


customFileInputs.forEach((input, index) => {
    const uploadLabel = document.getElementById(`uploadLabel${index + 1}`);
    const preview = document.getElementById(`preview${index + 1}`);
    const previewEdit = document.getElementById(`previewEdit${index + 1}`);
    const ButtonDelete = document.getElementById(`delete${index + 1}`);

    let originalImage = null;
 

    input.addEventListener('change', function () {
        const files = input.files;
    
        if (files.length > 0) {
            // 隐藏上传按钮
            uploadLabel.style.display = 'none';
        }

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.alt = e.target.result;
                    previewEdit.src = e.target.result;
                    previewEdit.alt = e.target.result;
                };        
            ButtonDelete.addEventListener('click', function() {
            preview.src = '';
            preview.alt = '';
            previewEdit.src = '';
            previewEdit.alt = '';
            uploadLabel.style.display = 'block';
            input.value = '';
          });  
     
             reader.readAsDataURL(file);
            }
        }

    });

});

