const Table = ( tablehead,tablebody) => (` 
    <div class="div-table">
        <div class="div-table-head">
            ${tablehead}
              <!--<ul>
                <li>Name</li>
                <li>Phone</li>
                <li>Residence</li>
              </ul>-->
        </div>
        <div class="div-table-body">
            ${tablebody}
            <!--<ul>
            <li>Name</li>
            <li>Phone</li>
            <li>Residence</li>
            </ul>
            <ul>
            <li>Name</li>
            <li>Phone</li>
            <li>Residence</li>
            </ul>-->
        </div>
    </div>

`)

export default Table