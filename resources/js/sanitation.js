
const BASE_URL = "http://localhost/dev/public";

new Vue({
  el: '#sanitation-container',
  data() {
  	return {
  		dataToBeSanitized:[],
  		sanitationCount: 0,
		sanitizedByDoctorName:[],
		sanitizedByDoctorNameCount: 0,
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

			for(let rawDoctor of this.dataToBeSanitized) {
				this.sanitizeByDoctorName(rawDoctor.raw_doctor)
			}
		})
  	},
  	sanitizeByDoctorName: function(mdName) {

  		this.sanitationLabel = 'Sanitizing by MD Name...';

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
  	}
  }
});