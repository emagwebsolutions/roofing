

    /*############################# 
    * Y-m-d Date Format
    #############################*/
    function ymd(date){
        const d = new Date(date)
        const year =  d.getFullYear()
        const month = d.getMonth()+1
        const day = d.getDate()
        const mnt = month < 10? "0"+month : month
        const dy = day < 10 ? "0"+day : day
        return `${year}-${mnt}-${dy}`
    }


    function ymdslash(date){
        const d = new Date(date)
        const year =  d.getFullYear()
        const month = d.getMonth()+1
        const day = d.getDate()
        const mnt = month < 10? "0"+month : month
        const dy = day < 10 ? "0"+day : day
        return `${mnt}/${dy}/${year}`
    }

    function ym(date){
        const d = new Date(date)
        const year =  d.getFullYear()
        const month = d.getMonth()+1
        const mnt = month < 10? "0"+month : month
        return `${year}-${mnt}`
    }


    function formatDate(dateObject) {
        const d = new Date(dateObject);
        const day = d.getDate();
        const months = d.getMonth();
        const mnth = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']
        const month = mnth[months]
        const year = d.getFullYear();
        const days = (day < 10)? "0" + day : day
        const monthx = (Number(month) < 10)? "0" + month : month
        const date = days + " " + monthx + " " + year;
        return date;
    };

    function formatMonth() {
        const d = new Date();
        const months = d.getMonth();
        const mnth = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']
        const month = mnth[months]
        return month;
    };

    function daysleft(cdate,fdate){
        const futuredate = new Date(fdate)
		const curdate = new Date(cdate)
		const newdate = futuredate.getTime() - curdate.getTime()
		const days = Math.floor(newdate / (1000*60*60*24))
        return days
    }

    export {ymd,formatDate,ym,daysleft,ymdslash,formatMonth}
