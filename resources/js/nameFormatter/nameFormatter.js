new Vue({
  el: '#nfContainer',
  data() {
  	return {
		dataToBeSanitized:[], //hold all the MD that need to sanitize
		nfLabel: '',
		nfByDoctorNameIndex: 0, //this will loop inside dataToBeSanitized array to go through every MD
		nfByDoctorNameCount: 0,
		nfByDoctorNamePercentage: 0,
		leftNFLogs : '',//left logs hold all MD that is currently sanitizing or previously
		rightNFLogs :'',//right logs hold all found MD
		nfByDoctorName:[], //hold the MD that is existing in db_sanitation tbl per request
  		nfBtn: false,
		nfCount: 0,
		nfTotalFound : 0,
	  }
  },
  updated() {
	document.getElementById('leftLogsNameFormatter').scrollTop = document.getElementById('leftLogsNameFormatter').scrollHeight;
  },
  methods: {
	  
	nameFormat: function(){
		this.nfLabel = "Scanning . . . ";
		/* alert('Clicking Button!'); */
		
		axios.get(`sanitation/get-all-md`)
		.then((response) => {
			console.log(response);
		})
		.catch((error) => {
			console.log(error);
		})
	},


	getByNameFormat : function(){

	}
  } // end of methods
});