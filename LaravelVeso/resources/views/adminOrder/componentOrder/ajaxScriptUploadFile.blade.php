<script type="text/javascript">
function handleSubmitUploadFile(formId){
    var formData = new FormData(document.getElementById(formId));

    axios.post('{{ route('order.uploadFileOrderDetail')}}',formData)
    .then((response) => {    
        console.log(response);  
        document.getElementById("img-"+formId).src = "{{asset('storage')}}/"+response['data'];
    })
}
</script>