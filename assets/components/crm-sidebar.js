import {formatDate} from './formatDate.js'
customElements.define('nav-links', class extends HTMLElement{
constructor(){
    super();
    this.attachShadow({mode : 'open'})
}

connectedCallback(){
  
    this.shadowRoot.innerHTML = `

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
    a{
        color: black;
    }
    </style>

    <a class="list-group-item" href="${this.attributes.link.value}"> 
    ${this.attributes.name.value}
    </a>
    `;
   
}

});

//<nav-links link="" fa="" name=""></nav-links>



customElements.define('closing-date', class extends HTMLElement{
    constructor(){
        super();
        this.attachShadow({mode : 'open'})
    }
    connectedCallback(){
            axios.get('router.php?controller=crm&task=closing_this_month')
            .then(res => {
              let result = '';
              res.data.forEach(v => {
               result +=  `
               <div class="col-md-12 mb-1">
               <div class="card">
                   <div class="card-header">
                   ${v.opp_name}
                   </div>
                   <div class="card-body">
                     <h5 class="card-title">${formatDate(v.closing_date)}</h5>
                     <p class="card-text">${v.stage}</p>
                     <a href="?page=viewopportunity&crm_id=${v.crm_id}" class="btn btn-primary btn-sm">View Opportunity</a>
                   </div>
                 </div>
               </div>
              `;
            });
            this.shadowRoot.innerHTML = `
            <link rel="stylesheet" href="assets/css/bootstrap.min.css">
            ${result}`;
        });
    }
});
//<closing-date></closing-date>


customElements.define('leads-sidebar', class extends HTMLElement{
constructor(){
    super();
    this.attachShadow({mode: 'open'})
}
connectedCallback(){
    this.shadowRoot.innerHTML = `
    <nav class="list-group list-group-flush">
    <nav-links link="?page=leads" name="All Leads"></nav-links>
    <nav-links link="?page=converted-leads" name="Converted Leads"></nav-links>
    <nav-links link="?page=not-contacted-leads" name="Not Contacted Leads"></nav-links>
    <nav-links link="?page=today-leads" name="Today's Leads"></nav-links>
    </nav>
    `
}
})


customElements.define('opp-sidebar', class extends HTMLElement{
    constructor(){
        super();
        this.attachShadow({mode: 'open'})
    }
    connectedCallback(){
        this.shadowRoot.innerHTML = `
        <nav class="list-group list-group-flush">
        <nav-links link="?page=opportunity" name="All Opportunities"></nav-links>
        <nav-links link="?page=needs-analysis" name="Needs Analysis"></nav-links>
        <nav-links link="?page=closed-won" name="Closed Won"></nav-links>
        <nav-links link="?page=closed-lost" name="Closed Lost"></nav-links>
        </nav>
        `
    }
    })



