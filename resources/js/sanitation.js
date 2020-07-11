
const BASE_URL = "http://localhost/mdc/public";

new Vue({
  el: '#sanitation-container',
  data() {
  	return {
  		dataToBeSanitized:[],
  		sanitationCount: 0,
		sanitizedByDoctorName:[],
		sanitizedByDoctorNameCount: 0,
		sanitizedByDoctorNameIndex: 0,
		sanitationLabel: '',
  	}
  },
  methods: {
  	startSanitize: function() {

  		this.sanitationLabel = 'Scanning....';

		axios.get(`${BASE_URL}/sanitation/`)
		.then((response) => {

			this.dataToBeSanitized = response.data;
			this.sanitationLabel = 'Total';
			this.sanitationCount = this.dataToBeSanitized.length;
		})
		.catch((error) => {

			console.log(error);
		})
		.finally(() => {

			this.sanitizeByDoctorName(this.dataToBeSanitized[this.sanitizedByDoctorNameIndex].raw_doctor)
		})
	  },
	stopSanitized : function(){
		this.sanitationLabel = 'Stopping....';
		axios.get(`${BASE_URL}/sanitation/`)
		.then((response) => {
			this.sanitationCount = 'Sanitation was cancelled';
		})
	},
  	sanitizeByDoctorName: function(mdName) {

  		this.sanitationLabel = `Analyzing MD name: ${mdName}`;

		let data = {
			mdName: mdName
		}

		axios.post(`${BASE_URL}/sanitation/md`, data)
		.then((response) => {

			this.sanitizedByDoctorName = response.data;
			this.sanitationLabel = 'Sanitizing By Name';
			this.sanitizedByDoctorNameCount += 1;
		})
		.catch((error) => {
			console.log(error);
		})
		.finally(() => {

			if( this.sanitationCount >= this.sanitizedByDoctorNameIndex ) {
				this.sanitizedByDoctorNameIndex += 1;
				this.sanitizeByDoctorName(this.dataToBeSanitized[this.sanitizedByDoctorNameIndex].raw_doctor)
			}
		})
  	}
  }
});