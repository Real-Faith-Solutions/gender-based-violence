<script>
    function submitDataForms(urls, formName, modalName){
        const url = urls;
        fetch(url, {
            method : "POST",
            body: new FormData(document.getElementById(formName)),
        }).then(
            response => response.text() // .json(), etc.
            // same as function(response) {return response.text();}
        ).then(
            html => console.log(html)
        );

        $('#'+modalName).modal('hide');
        location.reload();
    }
</script>
