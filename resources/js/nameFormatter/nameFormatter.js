new Vue({
  el: '#nfContainer',
  data() {
  	return {
  		dataToBeSanitized:[], //hold all the MD that need to sanitize
  		nfBtn: false,
  		nfCount: 0,
		nfByDoctorName:[], //hold the MD that is existing in db_sanitation tbl per request
		nfByDoctorNameCount: 0,
		nfByDoctorNameIndex: 0, //this will loop inside dataToBeSanitized array to go through every MD
		nfByDoctorNamePercentage: 0,
		nfByDoctorNameLogs:'', //left logs hold all MD that is currently sanitizing or previously
		nfByDoctorNameFoundLogs:'', //right logs hold all found MD
		nfByDoctorNameFoundLogsCount: 0,
		nfByDoctorNameDuplicateLogsCount: 0,
		nfByDoctorNameFound:[],
		nfLabel: '',
  	}
  },
  updated() {
	document.getElementById('ruleLogs').scrollTop = document.getElementById('ruleLogs').scrollHeight;
  },
  methods: {
  // 	startSanitize: function() {

  // 		this.sanitationLabel = 'Scanning....';

		// axios.get(`get-all-md`)
		// .then((response) => {

		// 	this.dataToBeSanitized = response.data;
		// 	this.sanitationLabel = 'Total';
		// 	this.sanitationCount = this.dataToBeSanitized.length;
		// })
		// .catch((error) => {

		// 	console.log(error);
		// })
		// .finally(() => {

		// 	//sanitizedByDoctorNameIndex = 0
		// 	//we want to start at 0 since array start 0
		// 	let rawId = this.dataToBeSanitized[this.sanitizedByDoctorNameIndex].raw_id;
		// 	let rawDoctor = this.dataToBeSanitized[this.sanitizedByDoctorNameIndex].raw_doctor;

		// 	this.sanitizeByDoctorName(rawId, rawDoctor);
		// })
  // 	},
  // 	sanitizeByDoctorName: function(rawId, mdName) {

  // 		this.sanitationLabel = `${mdName}`;

		// let data = {
		// 	rawId: rawId,
		// 	mdName: mdName
		// }

		// axios.post(`phase-one/get-single-md`, data)
		// .then((response) => {

		// 	this.sanitizedByDoctorName = response.data;
		// 	this.sanitationLabel = 'Phase 1 done.';

		// 	//do we have MD?
		// 	if(this.sanitizedByDoctorName.length > 0) {

		// 		//do we only have 1 record on md_sanitation tbl?
		// 		if(this.sanitizedByDoctorName.length === 1) {

		// 			//left logs that shows the BLUE font when found an MD
		// 			this.sanitizedByDoctorNameLogs += `
		// 			<span style="font-size:13px;">
		// 				(${this.dataToBeSanitized[this.sanitizedByDoctorNameIndex].raw_id}) ${this.dataToBeSanitized[this.sanitizedByDoctorNameIndex].raw_doctor}
		// 				-
		// 				<span style="color:blue;">(${this.sanitizedByDoctorName.length}) FOUND</span>
		// 			<span>
		// 			<br>`;

		// 			//right logs
		// 			this.sanitizedByDoctorNameFoundLogs += `
		// 			<span style="font-size:13px;">
		// 				<span style="color: red; ">
		// 					(${this.dataToBeSanitized[this.sanitizedByDoctorNameIndex].raw_id}) ${this.dataToBeSanitized[this.sanitizedByDoctorNameIndex].raw_doctor}
		// 				</span>
		// 				<br>
		// 				<span style="color: blue">
		// 					(${this.sanitizedByDoctorName[0].sanit_id}) ${this.sanitizedByDoctorName[0].sanit_mdname} |
		// 					${this.sanitizedByDoctorName[0].sanit_universe} |
		// 					${this.sanitizedByDoctorName[0].sanit_group}
		// 				</span>
		// 			</span>
		// 			<br>----------------------------------<br>
		// 			`;

		// 			this.sanitizedByDoctorNameFoundLogsCount += 1;


		// 			let rawId = this.dataToBeSanitized[this.sanitizedByDoctorNameIndex].raw_id;
		// 			let group = this.sanitizedByDoctorName[0].sanit_group;
		// 			let mdName = this.sanitizedByDoctorName[0].sanit_mdname;
		// 			let universe = this.sanitizedByDoctorName[0].sanit_universe;
		// 			let mdCode = this.sanitizedByDoctorName[0].sanit_id;


		// 			this.sanitizeNow(rawId, group, mdName, universe, mdCode);
		// 		}else {

		// 			this.sanitizedByDoctorNameFoundLogs += `
		// 				<span style="font-size:13px; color:red;">
		// 					${this.dataToBeSanitized[this.sanitizedByDoctorNameIndex].raw_doctor} - (${this.sanitizedByDoctorName.length}) FOUND
		// 					<i>ignoring, fix the duplicates first for this keyword</i>
		// 				</span>
		// 				<br>----------------------------------<br>`;
		// 			this.sanitizedByDoctorNameDuplicateLogsCount += 1;
		// 		}
		// 	}

		// 	//proceed to the next MD's
		// 	if( this.sanitationCount !== this.sanitizedByDoctorNameIndex ) {

		// 		this.sanitizedByDoctorNameCount += 1;
		// 		this.sanitizedByDoctorNamePercentage = ((this.sanitizedByDoctorNameCount / this.sanitationCount) * 100).toFixed(2);

		// 		//left logs, MD's not found.
		// 		if(this.sanitizedByDoctorName.length < 1) {
		// 			//left logs
		// 			this.sanitizedByDoctorNameLogs += `<span style="font-size:13px;">(${this.dataToBeSanitized[this.sanitizedByDoctorNameIndex].raw_id}) ${this.dataToBeSanitized[this.sanitizedByDoctorNameIndex].raw_doctor}</span><br>`;
		// 		}


		// 		//sanitizedByDoctorNameIndex incremented by 1 every execution
		// 		//to proceed to the next element of dataToBeSanitized array
		// 		//proceeding to the next element means another MD to be sanitize
		// 		this.sanitizedByDoctorNameIndex += 1;

		// 		if(typeof this.dataToBeSanitized[this.sanitizedByDoctorNameIndex] !== 'undefined') {
		// 			this.sanitizeByDoctorName(this.dataToBeSanitized[this.sanitizedByDoctorNameIndex].raw_id, this.dataToBeSanitized[this.sanitizedByDoctorNameIndex].raw_doctor);
		// 			this.sanitationBtn = true;
		// 		}else {
		// 			// this.sanitationBtn = false;
		// 			this.sanitationLabel = 'Moving to next Phase . . . ';
		// 			window.setTimeout(function () {
		// 				window.location.href = `phase-two`;
		// 			}, 3000);
		// 		}
		// 	}else {
		// 		console.log("end end end");
		// 		window.open('phase-two', '_blank');
		// 	}


		// })
		// .catch((error) => {
		// 	console.log(error);
		// })
	 //  },

  // 	sanitizeNow: function(rawId, group, mdName, universe, mdCode) {
  // 		let data = {
  // 			rawId: rawId,
  // 			group: group,
  // 			mdName: mdName,
  // 			universe: universe,
  // 			mdCode: mdCode
  // 		}

  // 		axios.post(`phase-one/get-single-md/sanitize`, data, {
  // 			headers:{
  // 				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  // 			}
  // 		})
  // 		.then((response) => {

  // 		})
  // 		.catch((error) => {

  // 		})
	 //  },

  }
});