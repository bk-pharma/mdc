
const BASE_URL = "http://server001.bell-kenz.com/mdc-newmdc/public";
//sub phase
const SUB_PHASE_URL = "http://server001.bell-kenz.com/mdc-new/mdc/public/sanitation/phase-four";


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
      totalFound: 0,

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

        let rawId = this.dataToBeSanitized[this.dataToBeSanitizedIndex].raw_id;
        let md = this.dataToBeSanitized[this.dataToBeSanitizedIndex].raw_doctor;
        let licenseNo = this.dataToBeSanitized[this.dataToBeSanitizedIndex].raw_license;

        this.sanitationLabel = md;

        this.getMD(rawId, md, licenseNo);
      })
      .catch((error) => {

      });
    },
    getMD: function(rawId, mdName, licenseNo) {

      let data = {
        rawId: rawId,
        mdName: mdName,
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

          let rawId = this.dataToBeSanitized[this.dataToBeSanitizedIndex].raw_id;
          let md = this.dataToBeSanitized[this.dataToBeSanitizedIndex].raw_doctor;
          let licenseNo = this.dataToBeSanitized[this.dataToBeSanitizedIndex].raw_license;

          this.sanitationLabel = md;

          this.getMD(rawId, md, licenseNo);
        } 
        
        if(typeof this.dataToBeSanitized[this.dataToBeSanitizedIndex] !== 'undefined') {
					this.sanitationBtn = true;
				}else {
          // this.sanitationBtn = false;
					this.sanitationLabel = 'Moving to next Phase . . . ';
					window.setTimeout(function () {
						window.location.href = `${SUB_PHASE_URL}`;
					}, 3000);
				}
      })
      .catch((error) => {

      })

    }
  },
  mounted(){
    this.startSanitize();
  }
});