new Vue({
    el: '#automatedPhases-container',
    data() {
        return {
           currentIndex: 0, // nextIndex = array[index + 10]
           automatedLabel : '',
           sanitationBtn: false,
           processRowStartArr: [],
           rowCount: 0,
           rowCountField: false,
           totalSanitizedRow: 0,
           percentageSanitizedRow: 0,
           totalUnsanitizedRow: 0,
           totalSanitizedAmount: 0,
           totalRaw: 0,
           rowsPerSanitationProcess: 100,
           currentSanitationProcess: 0,
           totalSanitationProcess:  0,
           percentageSanitationProcess: 0
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
        },
        decimalFormat: function(num)
        {
            if(num || !isNaN(num))
            {
                return num.toFixed(2);
            }else
            {
                return num;
            }
        }
    },
    created()
    {
        this.initialData();
    },
    updated()
    {
        if(this.currentSanitationProcess === this.totalSanitationProcess)
        {
            this.automatedLabel = '';
            this.sanitationBtn = false;
            this.rowCountField = false;
        }
    },
    methods : {
        startConsole: function()
        {
            this.automatedLabel = 'Sanitation in process...';

            let sanitationProcessNeeded = (this.rowCount / this.rowsPerSanitationProcess);
            let processPerArray = (sanitationProcessNeeded / 10);
            let processRowStart = 0;

            for(let i = 0; i < sanitationProcessNeeded; i++)
            {
                if(i === 0)
                {
                    processRowStart = 0;
                }else
                {
                    processRowStart = (i * this.rowsPerSanitationProcess) + 1;
                }

                this.processRowStartArr.push(processRowStart);
            }

            this.totalSanitationProcess = Math.round(sanitationProcessNeeded) + 1;


            this.sanitationProcess1(this.currentIndex);
            this.currentIndex += 1;

            this.sanitationProcess2(this.currentIndex);
            this.currentIndex += 1;
        },
        sanitationProcess1: function(index)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            this.currentSanitationProcess += 1;

            let rowStart = this.processRowStartArr[index];

            let data = {
                rowStart: rowStart,
                rowCount: this.rowsPerSanitationProcess
            };

            axios.post(`automated/start-process`, data)
            .then((response) =>
            {
                let resp = response.data;

                let nextIndex = this.currentIndex + 1;

                if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                {
                    this.currentIndex += 1;
                    this.sanitationProcess1(nextIndex);
                }

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / resp.totalRaw) * 100;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;
            })
            .catch((error) =>
            {
                console.log(error);
            })
        },
        sanitationProcess2: function(index)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            this.currentSanitationProcess += 1;

            let rowStart = this.processRowStartArr[index];

            let data = {
                rowStart: rowStart,
                rowCount: this.rowsPerSanitationProcess
            };

            axios.post(`automated/start-process`, data)
            .then((response) =>
            {
                let resp = response.data;

                let nextIndex = this.currentIndex + 1;

                if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                {
                    this.currentIndex += 1;
                    this.sanitationProcess2(nextIndex);
                }

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / resp.totalRaw) * 100;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;
            })
            .catch((error) =>
            {
                console.log(error);
            })
        },
        initialData:function()
        {
            axios.get(`automated/sanitized-total`)
            .then((response) =>
            {
                let resp = response.data;
                this.rowCount = (resp.totalRaw - resp.totalSanitized);
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (resp.totalRaw - resp.totalSanitized);
            })
            .catch((error) =>
            {
                console.log(error);
            })
        }
    }
});