new Vue({
  el: '#importContainer',
  data() {
  	return {
  		file: '',
  		fileName:'',
      uploadBtn: false,
      browseBtn: false,
      totalRaw: 0,
      status: '',
      runTime: '',
      startTime: '',
      endTime: '',
      isImporting: false,
      importErrors: []
	  }
  },
  filters: {
      numberFormat: function(num)
      {
          if(num)
          {
              return num.toLocaleString();
          }else
          {
              return num;
          }
      }
  },
  mounted() {
    if (localStorage.startTime) {
      this.startTime = localStorage.startTime;
    }
  },
  created()
  {
    this.runTime = '';
  },
  methods: {
  	handleFileUpload: function ()
  	{
  		this.file = this.$refs.file.files[0];
  	  	$('.custom-file-input').siblings(".custom-file-label").addClass("selected").html(this.file.name);
  	},
  	submitFile: function()
  	{
      this.status = 'Importing....';
      this.browseBtn = true;
      this.uploadBtn = true;
      this.isImporting = true;

      localStorage.startTime = new Date().getTime();
      this.startTime = localStorage.startTime;
      this.runTime = '00h 00m 00s';

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
       .then((response) =>
       {
          let resp = response.data;
          console.log(resp);
          this.status = 'Importing done.';
          this.browseBtn = false;
          this.uploadBtn = false;
          this.isImporting = false;
      })
      .catch((error) =>
      {
        let errorResp = error.response.data.errors;

        console.log(errorResp);

        if(errorResp.rawExcel) this.status = errorResp.rawExcel[0];
        if(errorResp.branch_code) this.status = errorResp.branch_code[0];
        if(errorResp.transact_date) this.status = errorResp.transact_date[0];
        if(errorResp.md_name) this.status = errorResp.md_name[0];
        if(errorResp.ptr) this.status = errorResp.ptr[0];
        if(errorResp.address) this.status = errorResp.address[0];
        if(errorResp.item_code) this.status = errorResp.item_code[0];
        if(errorResp.item_name) this.status = errorResp.item_name[0];
        if(errorResp.qty) this.status = errorResp.qty[0];
        if(errorResp.amount) this.status = errorResp.amount[0];

        this.browseBtn = false;
        this.uploadBtn = false;
        this.isImporting = false;
        this.runTime = '';
      });

      setInterval(() =>
      {
        this.getAllRawData();
      }, 6000);
  	},
    getAllRawData: function()
    {
      axios.get('raw-data/all')
      .then((response) =>
      {
        let resp = response.data;

        this.totalRaw = resp.totalRaw;

        if(this.isImporting)
        {
          this.endTime = new Date().getTime();
          this.runTime = this.convertToString(this.endTime - this.startTime);
        }else
        {
          if(this.totalRaw)
          {
            this.runTime = this.convertToString(this.endTime - this.startTime);
          }else
          {
            this.runTime = '';
          }
        }

      })
      .catch((error) => {
        console.log(error);
      });
    },
    convertToString:function(millis)
    {
        /*
            https://gist.github.com/robertpataki/d0b40a1cbbb71764dd94e16cbc99d42f
         */
        let delim = " ";
        let hours = Math.floor(millis / (1000 * 60 * 60) % 60);
        let minutes = Math.floor(millis / (1000 * 60) % 60);
        let seconds = Math.floor(millis / 1000 % 60);
        hours = hours < 10 ? '0' + hours : hours;
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;
        return hours + 'h'+ delim + minutes + 'm' + delim + seconds + 's';
    }
  }
});