/* Sanitizing specific text using array */

const BASE_URL = "http://localhost/mdc/public";

new Vue({
  el: '#sanitation-container',
  data() {
  	return {
        dataToBeSanitized:[],
        sanitizedByDoctorNameRemovedChar:["]DR ","]R ","]RA ","`DR ","`DRA ","`R ","DR ","DR  ","D   ","DR A ","DR DR ","DR. ","DR.","DR/ ","DR] ","DR]","DRA  ","MD "," JR"," SR"],
        sanitationCount: 0,
		sanitizedByDoctorName:[],
		sanitizedByDoctorNameCount: 0,
		sanitizedByDoctorNameIndex: 0,
        sanitationLabel: ''
    }
  },
  methods: {
  	startSanitized: function() {
          
        this.sanitationLabel = 'Scanning....';

		axios.get(`${BASE_URL}/sanit/`)
		.then((response) => {

            this.dataToBeSanitized = response.data;
            this.sanitationLabel = 'Total';
            this.sanitationCount = this.dataToBeSanitized.length;
            
            for (let data of this.dataToBeSanitized) {
                for (let removedChar of this.sanitizedByDoctorNameRemovedChar) {
                    let sanitizedMD = data.raw_doctor.replace(removedChar, "");
                    console.log(sanitizedMD);
                    
                }
            }
		})
		.catch((error) => {
			console.log(error);
        })
        .finally(() => {

			this.dataToBeSanitized[this.sanitizedByDoctorNameIndex].raw_doctor
		})
  	},
      stopSanitized : function(){
		this.sanitationLabel = 'Stopping....';
		axios.get(`${BASE_URL}/sanitation/`)
		.then((response) => {
			this.sanitationCount = 'Sanitation was cancelled';
		})
	},
      SanitizedByPrefix : function(mdName) {

      this.sanitationLabel = `Analyzing MD name: ${mdName}`;

      let data = {
          mdName: mdName
      }

      axios.post(`${BASE_URL}/sanit/superMD`, data)
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
              this.dataToBeSanitized[this.sanitizedByDoctorNameIndex].raw_doctor
          }

      })
    }
  }
});

