new Vue({
  el: '#rulesContainer',
  data() {
  	return {
		dataToBeSanitized:[], //hold all the MD that need to sanitize
		rulesLabel: '',
		rulesByDoctorNameIndex: 0, //this will loop inside dataToBeSanitized array to go through every MD
		rulesByDoctorNameCount: 0,
		rulesByDoctorNamePercentage: 0,
		leftRuleLogs : '',//left logs hold all MD that is currently sanitizing or previously
		rightRuleLogs :'',//right logs hold all found MD
		rulesByDoctorName:[], //hold the MD that is existing in db_sanitation tbl per request
  		rulesBtn: false,
		rulesCount: 0,
		rulesTotalFound : 0,
		
	/* 	rulesByDoctorNameLogs:'', 
		rulesByDoctorNameFoundLogs:'',  */
		rulesByDoctorNameFoundLogsCount: 0,
		rulesByDoctorNameDuplicateLogsCount: 0,
		rulesByDoctorNameFound:[],
  	}
  },
  updated() {
	document.getElementById('leftLogsRule').scrollTop = document.getElementById('leftLogsRule').scrollHeight;
  },
  methods: {

	applyRules : function(){
		/* alert('Clicking Button!'); */
		this.rulesLabel = ' Scanning . . . .'; 

		axios.get(`sanitation/get-all-md`)

		.then((response) => {
			/* console.log(response); */
			this.dataToBeSanitized = response.data;
			this.rulesCount = this.dataToBeSanitized.length;
			
			
			let raw_id = this.dataToBeSanitized[this.rulesByDoctorNameIndex].raw_id;
			let mdName = this.dataToBeSanitized[this.rulesByDoctorNameIndex].raw_doctor;
			let raw_license = this.dataToBeSanitized[this.rulesByDoctorNameIndex].raw_license;

			/* console.log(raw_id + ' -- ' + mdName + '--' + raw_license); */
			this.getByAppliedRules(raw_id, mdName, raw_license);
		})
		.catch((error) => {
			console.log(error);
		})
	},

	getByAppliedRules : function(raw_id, mdName, raw_license){
		this.rulesLabel = `${mdName}`;
		let data = {
			raw_id : raw_id,
			mdName: mdName,
			raw_license : raw_license,
		  }

		axios.post(`rules/get-single-md`, data)

		.then((response) => {
				
			this.rulesByDoctorName = response.data;
			this.rulesLabel = 'Applying Rules Done!';
			console.log(response.data);


		if(this.rulesByDoctorName !== "") {
			this.leftRuleLogs += `
			  <span style="font-size:13px;">
				(${this.dataToBeSanitized[this.rulesByDoctorNameIndex].raw_id}) ${this.dataToBeSanitized[this.rulesByDoctorNameIndex].raw_doctor}
				  -
				<span style="color:blue;">FOUND</span>
			  </span>
			  <br>`;
  
			this.rightRuleLogs += `
			  <span style="font-size:13px;">
				<span style="color:red;">(${this.dataToBeSanitized[this.rulesByDoctorNameIndex].raw_id}) ${this.dataToBeSanitized[this.rulesByDoctorNameIndex].raw_doctor}</span>
				<br>----------------------------------<br>
			  </span>
			  `;
  
  
			this.rulesTotalFound += 1;
		  }else {
			this.leftRuleLogs += `
			<span style="font-size:13px;">
			  (${this.dataToBeSanitized[this.rulesByDoctorNameIndex].raw_id}) ${this.dataToBeSanitized[this.rulesByDoctorNameIndex].raw_doctor}
			</span>
			<br>
			`;
  
		  }
		  this.rulesByDoctorNameIndex += 1;
		  this.rulesByDoctorNamePercentage = ((this.rulesByDoctorNameIndex / this.rulesCount) * 100).toFixed(2);
  
  
		  if(this.rulesByDoctorNameIndex < this.dataToBeSanitized.length) {
  
			let raw_id = this.dataToBeSanitized[this.rulesByDoctorNameIndex].raw_id;
			let mdName = this.dataToBeSanitized[this.rulesByDoctorNameIndex].raw_doctor;
			let raw_license = this.dataToBeSanitized[this.rulesByDoctorNameIndex].raw_license;
  
			this.sanitationLabel = mdName;
  
			this.getByAppliedRules(raw_id, mdName, raw_license);
		  } 
			
		})
		.catch((error) => {
			console.log(error);
		})
	},
  }, //end of methods
});