new Vue({
    el: '#automatedPhases-container',
    data() {
        return {
           sanitationIterator: 10,
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
           rowsPerSanitationProcess: 50,
           currentSanitationProcess: 0,
           totalSanitationProcess:  0,
           percentageSanitationProcess: 0
        }
    },
    created() {
        this.sanitizedCount('start');
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
    methods : {
        startConsole: function()
        {
            this.automatedLabel = 'Sanitation in process...';

            let sanitationProcessNeeded = (this.rowCount / this.rowsPerSanitationProcess);
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

            this.totalSanitationProcess = (this.processRowStartArr.length - 1);

            for(let i = 0; i <= this.sanitationIterator; i++)
            {
                this.sanitationProcess(i);
            }
        },
        sanitationProcess: function(index)
        {
            this.currentSanitationProcess = index;
            this.rowCountField = true;
            this.sanitationBtn = true;

            let rowStart = this.processRowStartArr[index];

            axios.get(`automated/start-process/${rowStart}/${this.rowsPerSanitationProcess}`)
            .then((response) =>
            {
                this.sanitizedCount(null);

                let nextRowStart = this.processRowStartArr[index + this.sanitationIterator];
                let nextIndex = index + this.sanitationIterator;

                if(typeof nextRowStart !== 'undefined')
                {
                    this.sanitationProcess(nextIndex);
                }else
                {
                    this.automatedLabel = '';
                    this.rowCountField = false;
                    this.sanitationBtn = false;
                }
            })
            .catch((error) =>
            {
                console.log(error);
            })
        },
        sanitizedCount: function(callFrom)
        {
            axios.get(`automated/sanitized-total`)
            .then((response) =>
            {
                let resp = response.data;

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.percentageSanitizedRow = (resp.totalSanitized / resp.totalRaw) * 100;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;

                if(callFrom === 'start')
                {
                    this.rowCount = this.totalUnsanitizedRow;
                    this.percentageSanitationProcess = 0;
                }
            })
            .catch((error) => {

            })
        }
    }

});