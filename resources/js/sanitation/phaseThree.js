
const BASE_URL = "http://localhost/dev/public";


new Vue({
  el: '#sanitationPhaseThree-container',
  data() {
  	return {
  		dataToBeSanitized: [],
      dataToBeSanitizedIndex: 0,
      sanitationLabel:'',
      sanitationCount: 0,
      sanitizedByDoctorNamePercentage: 0,
      leftLogs:'',
      rightLogs: '',
      foundMD:[],
      totalFound: 0
  	}
  },
  updated() {
	 document.getElementById('leftLogsPhaseThree').scrollTop = document.getElementById('leftLogsPhaseThree').scrollHeight;
  },
  methods: {
  	startSanitize: function() {

      axios.get(`${BASE_URL}/sanitation/get-all-md`)
      .then((response) => {

        this.dataToBeSanitized = response.data;
        this.sanitationCount = this.dataToBeSanitized.length;

        this.sanitationLabel = this.dataToBeSanitized[this.dataToBeSanitizedIndex].raw_doctor;

        let lastName = this.getLastName(this.dataToBeSanitized[this.dataToBeSanitizedIndex].raw_doctor);
        let firstName = this.getFirstName(this.dataToBeSanitized[this.dataToBeSanitizedIndex].raw_doctor);
        let licenseNo = this.dataToBeSanitized[this.dataToBeSanitizedIndex].raw_license;


        this.getMD(firstName, lastName, licenseNo);
        // for(let md of this.dataToBeSanitized) {
        //   console.log(`${md.raw_doctor} ---> ${this.filter(md.raw_doctor)}  ---> ${md.raw_license}`);
        // }
      })
      .catch((error) => {

      });
    },
    getMD: function(firstName, lastName, licenseNo) {

      let data = {
        firstName: firstName,
        lastName: lastName,
        licenseNo: licenseNo
      }

      axios.post(`${BASE_URL}/sanitation/phase-three/get-single-md`, data)
      .then((response) => {

        this.foundMD = response.data;
        this.sanitationLabel = 'Phase 3 done.';


        if(this.foundMD.length > 0) {


          this.leftLogs += `
            <span style="font-size:13px;">
              (${this.dataToBeSanitized[this.dataToBeSanitizedIndex].raw_id}) ${this.dataToBeSanitized[this.dataToBeSanitizedIndex].raw_doctor}
                -
              <span style="color:blue;">(${this.foundMD.length}) FOUND</span>
            </span>
            <br>`;

          this.rightLogs += `
            <span style="font-size:13px;">
              <span style="color:red;">(${this.dataToBeSanitized[this.dataToBeSanitizedIndex].raw_id}) ${this.dataToBeSanitized[this.dataToBeSanitizedIndex].raw_doctor}</span>
              <br>
              <span style="color:blue;">(${this.foundMD[0].sanit_id}) ${this.foundMD[0].sanit_mdname}</span>
              <br>----------------------------------<br>
            </span>
            `;


          this.totalFound += 1;
        }else {

          this.leftLogs += `
          <span style="font-size:13px;">
            (${this.dataToBeSanitized[this.dataToBeSanitizedIndex].raw_id}) ${this.dataToBeSanitized[this.dataToBeSanitizedIndex].raw_doctor}
          </span>
          <br>
          `;
        }


        this.dataToBeSanitizedIndex += 1;
        this.sanitizedByDoctorNamePercentage = ((this.dataToBeSanitizedIndex / this.sanitationCount) * 100).toFixed(2);


        if(this.dataToBeSanitizedIndex < this.dataToBeSanitized.length) {

          this.sanitationLabel = this.dataToBeSanitized[this.dataToBeSanitizedIndex].raw_doctor;

          let lastName = this.getLastName(this.dataToBeSanitized[this.dataToBeSanitizedIndex].raw_doctor);
          let firstName = this.getFirstName(this.dataToBeSanitized[this.dataToBeSanitizedIndex].raw_doctor);

          this.getMD(firstName, lastName, licenseNo);
        }

      })
      .catch((error) => {

      })

    },
    getLastName: function(mdName) {

      let splitMdName = mdName.split(' ');

      if(
        splitMdName[0].includes(']DR ') ||
        splitMdName[0].includes(']R ') ||
        splitMdName[0].includes(']RA ') ||
        splitMdName[0].includes('`DR ') ||
        splitMdName[0].includes('`DRA ') ||
        splitMdName[0].includes('`R ') ||
        splitMdName[0].includes('DR ') ||
        splitMdName[0].includes('DR  ') ||
        splitMdName[0].includes('D   ') ||
        splitMdName[0].includes('DR A ') ||
        splitMdName[0].includes('DR DR ') ||
        splitMdName[0].includes('DR. ') ||
        splitMdName[0].includes('DR.') ||
        splitMdName[0].includes('DR/ ') ||
        splitMdName[0].includes('DR] ') ||
        splitMdName[0].includes('DR]') ||
        splitMdName[0].includes('DRA  ') ||
        splitMdName[splitMdName.length - 1].includes('MD ') ||
        splitMdName[splitMdName.length - 1].includes('JR') ||
        splitMdName[splitMdName.length - 1].includes(' SR')
      ) {

        splitMdName.shift();
      }


      if(splitMdName.length === 3) {
        return `${splitMdName[2]}`;
      }else if(splitMdName.length === 2) {
        return `${splitMdName[1]}`;
      }else {
        return `${splitMdName[splitMdName.length - 1]}`;
      }
    },
    getFirstName: function(mdName) {

      let splitMdName = mdName.split(' ');

      if(
        splitMdName[0].includes(']DR ') ||
        splitMdName[0].includes(']R ') ||
        splitMdName[0].includes(']RA ') ||
        splitMdName[0].includes('`DR ') ||
        splitMdName[0].includes('`DRA ') ||
        splitMdName[0].includes('`R ') ||
        splitMdName[0].includes('DR ') ||
        splitMdName[0].includes('DR  ') ||
        splitMdName[0].includes('D   ') ||
        splitMdName[0].includes('DR A ') ||
        splitMdName[0].includes('DR DR ') ||
        splitMdName[0].includes('DR. ') ||
        splitMdName[0].includes('DR.') ||
        splitMdName[0].includes('DR/ ') ||
        splitMdName[0].includes('DR] ') ||
        splitMdName[0].includes('DR]') ||
        splitMdName[0].includes('DRA  ') ||
        splitMdName[splitMdName.length - 1].includes('MD ') ||
        splitMdName[splitMdName.length - 1].includes('JR') ||
        splitMdName[splitMdName.length - 1].includes(' SR')
      ) {

        splitMdName.shift();
      }


      if(splitMdName.length === 3) {
        return `${splitMdName[0]}`;
      }else if(splitMdName.length === 2) {
        return `${splitMdName[0]}`;
      }else {
        return `${splitMdName[splitMdName.length - 1]}`;
      }
    }
  }
});