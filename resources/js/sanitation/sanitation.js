new Vue({
    el: '#sanitation-container',
    data() {
        return {
           automatedLabel : '',
           sanitationBtn: false,
           totalRun: 0,
           processRowStartArr: [],
           rowCount: 0,
           previousSanitized:0,
           previousSanitizedPercentage:0,
           rowCountField: false,
           totalSanitizedRow: 0,
           percentageSanitizedRow: 0,
           totalUnsanitizedRow: 0,
           totalSanitizedAmount: 0,
           totalRaw: 0,
           rowsPerSanitationProcess: 500,
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
        if(this.currentSanitationProcess === 200) this.sanitationTwo();
        if(this.currentSanitationProcess === 400) this.sanitationThree();
    },
    methods : {
        initialData:function()
        {
            axios.get(`sanitation/sanitized-total`)
            .then((response) =>
            {
                let resp = response.data;
                this.rowCount = (resp.totalRaw - resp.totalSanitized);
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (resp.totalRaw - resp.totalSanitized);

                this.percentageSanitizedRow = (resp.totalSanitized / resp.totalRaw) * 100;

                this.previousSanitized = resp.totalSanitized;
                this.previousSanitizedPercentage = (resp.totalSanitized / resp.totalRaw) * 100;
            })
            .catch((error) =>
            {
                console.log(error);
            })
        },
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

            if(this.processRowStartArr.length < 600)
            {
                this.totalSanitationProcess = this.processRowStartArr.length;
            }else
            {
                this.totalSanitationProcess = 600;
            }

            let firstSanitationIndexes = [0, 199]; // 0 - 100k;
            let secondSanitationIndexes = [200, 399]; // 101k - 200k
            let thirdSanitationIndexes = [400, 599]; // 201k - 300k
            let fourthSanitationIndexes = [600, 799]; // 301k - 400k
            let fifthSanitationIndexes = [800, 999]; // 401k - 500k
            let sixthSanitationIndexes = [1000, 1199]; // 501k - 600k
            let seventhSanitationIndexes = [1200, 1399]; // 601k - 700k
            let eightSanitationIndexes = [1400, 1599]; // 701k - 800k
            let nineSanitationIndexes = [1600, 1799]; // 801k - 900k
            let tenthSanitationIndexes = [1800, 1999]; // 901k - 1M

            this.sanitationOne();

        },
        sanitationProcess1: function(indexStart, indexStop)
        {
            this.rowCountField = true;
            this.sanitationBtn = true;

            let rowStart = this.processRowStartArr[indexStart];

            let data = {
                rowStart: rowStart,
                rowCount: this.rowsPerSanitationProcess,
                sanitation: 1,
                index: indexStart,
                sanitationWorker1: this.sanitationWorker1
            };

            axios.post(`sanitation/start-process`, data)
            .then((response) =>
            {
                let resp = response.data;

                this.totalRaw = resp.totalRaw;
                this.totalSanitizedRow = resp.totalSanitized;
                this.totalSanitizedAmount = resp.totalAmount;
                this.totalUnsanitizedRow = (parseInt(resp.totalRaw) - parseInt(resp.totalSanitized));

                this.currentSanitationProcess += 1;

                this.percentageSanitizedRow = (resp.totalSanitized / resp.totalRaw) * 100;
                this.percentageSanitationProcess = (this.currentSanitationProcess / this.totalSanitationProcess) * 100;


                if(indexStart !== indexStop)
                {
                    let nextIndex = indexStart + 1;

                    if(typeof this.processRowStartArr[nextIndex] !== 'undefined')
                    {
                        this.sanitationProcess1(nextIndex, indexStop);
                    }
                }

                if(this.currentSanitationProcess === this.totalSanitationProcess)
                {
                    this.totalRun += 1;

                    if(this.totalRun <= 9)
                    {
                        this.currentSanitationProcess = 0;
                        this.previousSanitized = this.totalSanitizedRow
                        this.previousSanitizedPercentage = this.percentageSanitizedRow;
                        this.sanitationOne();
                    }else
                    {
                        this.automatedLabel = '';
                        this.sanitationBtn = false;
                        this.rowCountField = false;
                    }
                }

            })
            .catch((error) =>
            {
                console.log(error);
                this.sanitationProcess1(indexStart, indexStop);
            })
        },
        sanitationOne: function()
        {
            // 0 -100k
            if(typeof this.processRowStartArr[0] !== 'undefined') this.sanitationProcess1(0, 49);
            if(typeof this.processRowStartArr[50] !== 'undefined') this.sanitationProcess1(50, 99);
            if(typeof this.processRowStartArr[100] !== 'undefined') this.sanitationProcess1(100, 149);
            if(typeof this.processRowStartArr[100] !== 'undefined') this.sanitationProcess1(150, 199);

        },
        sanitationTwo: function()
        {
            // 101k - 200k
            if(typeof this.processRowStartArr[200] !== 'undefined') this.sanitationProcess1(200, 249);
            if(typeof this.processRowStartArr[250] !== 'undefined') this.sanitationProcess1(250, 299);
            if(typeof this.processRowStartArr[300] !== 'undefined') this.sanitationProcess1(300, 349);
            if(typeof this.processRowStartArr[350] !== 'undefined') this.sanitationProcess1(350, 399);
        },
        sanitationThree: function()
        {
            // 201k - 300k
            if(typeof this.processRowStartArr[400] !== 'undefined') this.sanitationProcess1(400, 449);
            if(typeof this.processRowStartArr[450] !== 'undefined') this.sanitationProcess1(450, 499);
            if(typeof this.processRowStartArr[500] !== 'undefined') this.sanitationProcess1(500, 549);
            if(typeof this.processRowStartArr[550] !== 'undefined') this.sanitationProcess1(550, 599);
        },
        sanitationFour: function()
        {
            // 301k - 400k
            if(typeof this.processRowStartArr[600] !== 'undefined') this.sanitationProcess1(600, 649);
            if(typeof this.processRowStartArr[650] !== 'undefined') this.sanitationProcess1(650, 699);
            if(typeof this.processRowStartArr[700] !== 'undefined') this.sanitationProcess1(700, 749);
            if(typeof this.processRowStartArr[750] !== 'undefined') this.sanitationProcess1(750, 799);
        },
        sanitationFive: function()
        {
            // 401k - 500k
            if(typeof this.processRowStartArr[800] !== 'undefined') this.sanitationProcess1(800, 849);
            if(typeof this.processRowStartArr[850] !== 'undefined') this.sanitationProcess1(850, 899);
            if(typeof this.processRowStartArr[900] !== 'undefined') this.sanitationProcess1(900, 949);
            if(typeof this.processRowStartArr[950] !== 'undefined') this.sanitationProcess1(950, 999);
        },
        sanitationSix: function()
        {
            // 501k - 600k
            if(typeof this.processRowStartArr[1000] !== 'undefined') this.sanitationProcess1(1000, 1049);
            if(typeof this.processRowStartArr[1050] !== 'undefined') this.sanitationProcess1(1050, 1099);
            if(typeof this.processRowStartArr[1100] !== 'undefined') this.sanitationProcess1(1100, 1149);
            if(typeof this.processRowStartArr[1150] !== 'undefined') this.sanitationProcess1(1150, 1199);
        },
        sanitationSeven: function()
        {
            // 601k - 700k
            if(typeof this.processRowStartArr[1200] !== 'undefined') this.sanitationProcess1(1200, 1249);
            if(typeof this.processRowStartArr[1250] !== 'undefined') this.sanitationProcess1(1250, 1299);
            if(typeof this.processRowStartArr[1300] !== 'undefined') this.sanitationProcess1(1300, 1349);
            if(typeof this.processRowStartArr[1350] !== 'undefined') this.sanitationProcess1(1350, 1399);
        },
        sanitationEight: function()
        {
            // 701k - 800k
            if(typeof this.processRowStartArr[1400] !== 'undefined') this.sanitationProcess1(1400, 1449);
            if(typeof this.processRowStartArr[1450] !== 'undefined') this.sanitationProcess1(1450, 1499);
            if(typeof this.processRowStartArr[1500] !== 'undefined') this.sanitationProcess1(1500, 1549);
            if(typeof this.processRowStartArr[1550] !== 'undefined') this.sanitationProcess1(1550, 1599);
        },
        sanitationNine: function()
        {
            // 801k - 900k
            if(typeof this.processRowStartArr[1600] !== 'undefined') this.sanitationProcess1(1600, 1649);
            if(typeof this.processRowStartArr[1650] !== 'undefined') this.sanitationProcess1(1650, 1699);
            if(typeof this.processRowStartArr[1700] !== 'undefined') this.sanitationProcess1(1700, 1749);
            if(typeof this.processRowStartArr[1750] !== 'undefined') this.sanitationProcess1(1750, 1799);
        },
        sanitationTen: function()
        {
            // 901k - 1M
            if(typeof this.processRowStartArr[1800] !== 'undefined') this.sanitationProcess1(1800, 1849);
            if(typeof this.processRowStartArr[1850] !== 'undefined') this.sanitationProcess1(1850, 1899);
            if(typeof this.processRowStartArr[1900] !== 'undefined') this.sanitationProcess1(1900, 1949);
            if(typeof this.processRowStartArr[1950] !== 'undefined') this.sanitationProcess1(1950, 1999);
        }
    }
});