
const BASE_URL = "http://localhost/dev/public";

new Vue({
  el: '#sanitation-container',
  data() {
  	return {
  		dataToBeSanitized:[],
  		sanitationCount: 0,
		sanitizedByDoctorName:[],
		sanitizedByDoctorNameCount: 0,
		sanitizedByDoctorNameIndex: 0,
		sanitizedByDoctorNamePercentage: 0,
  		sanitationLabel: ''
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
  	sanitizeByDoctorName: function(mdName) {

  		this.sanitationLabel = `Comparing ${mdName}`;

		let data = {
			mdName: mdName
		}

		axios.post(`${BASE_URL}/sanitation/md`, data)
		.then((response) => {

			this.sanitizedByDoctorName = response.data;
			this.sanitationLabel = 'Sanitizing By Name Done.';
			this.sanitizedByDoctorNameCount += 1;
			this.sanitizedByDoctorNamePercentage = (this.sanitizedByDoctorNameCount / this.sanitationCount) * 100;


			if( this.sanitationCount >= this.sanitizedByDoctorNameIndex ) {
				this.sanitizedByDoctorNameIndex += 1;
				this.sanitizeByDoctorName(this.dataToBeSanitized[this.sanitizedByDoctorNameIndex].raw_doctor)
			}


		})
		.catch((error) => {
			console.log(error);
		})
  	}
  }
});