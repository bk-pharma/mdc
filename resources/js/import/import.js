new Vue({
  el: '#importContainer',
  data() {
  	return {
  		file: '',
  		fileName:''
	  }
  },
  methods: {
	handleFileUpload()
	{
		this.file = this.$refs.file.files[0];
	  	$('.custom-file-input').siblings(".custom-file-label").addClass("selected").html(this.file.name);
	},
	submitFile()
	{
		 let formData = new FormData();
		 formData.append('rawExcel', this.file);

         axios.post( 'import/start',
                formData,
                {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              }
            )
         .then((response) => {
          console.log('SUCCESS!!');
        })
        .catch((error) => {
          console.log('FAILURE!!');
        });
	}
  }
});