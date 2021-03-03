
  var dosyaoku = function(event) {
    var input = event.target;
    var file = input.files[0];
    console.log(file.lastModifiedDate);
    Tesseract.recognize(
      file,
            'eng',
        ).then(({ data: { text } }) => {
            console.log(text);
            okunan_text=text;
            var kacinci=(okunan_text.indexOf("ISBN"));
            kacinci=kacinci+5;
            var kacinci_son=kacinci+17;
            var isbn=(okunan_text.slice(kacinci,kacinci_son));
            isbn=isbn.replace("-","");
            isbn=isbn.replace("-","");
            isbn=isbn.replace("-","");
            isbn=isbn.replace("-","");
            console.log(isbn);
            alert("Bulunan ISBN:"+isbn);
            document.cookie="isbn_kodu="+isbn;
        });
  };
