jQuery(document).ready(function(){

    /*
    *  Customers payment confirmed and sent for process 
    */ 
    Echo.channel('process')
    .listen('processEvent',function(){
        
        // Publish Notifications        
        if (! ('Notification' in window)) {
          alert('Web Notification is not supported');
          return;
        }

        Notification.requestPermission( permission => {
          let notification = new Notification('New Customer Request!', {
            body: "Please Check Your list, New Request received.",
          });
          
        });

        // update the list
        $.ajax({
           url: "/CRM/update/customer/process",
           method:'get',
           success:function(response)
           {
            $('#noc_table_body').empty().html(response);
           }
        });

    });
    
    // Publish notification by suspending the customers   
    Echo.channel('fiancneSuspend')
       .listen('financeSuspendEvent',function(){
            
        // Publish Notifications        
        if (! ('Notification' in window)) {
          alert('Web Notification is not supported');
          return;
        }

        Notification.requestPermission( permission => {
          let notification = new Notification('Customer Suspend!', {
            body: "Please Check Your list, New Customer Suspend.",
          });
          
        });

        // update the list
        $.ajax({
           url: "/CRM/suspend/noc/customer",
           method:'get',
           success:function(response)
           {
            $('#noc_table_suspend').empty().html(response);
           }
        });    

    });
    
    // Publish notification when customer has been suspended    
    Echo.channel('suspend')
        .listen('suspendEvent',function(){
           
         // Publish Notifications        
        if (! ('Notification' in window)) {
          alert('Web Notification is not supported');
          return;
        }

        Notification.requestPermission( permission => {
          let notification = new Notification('Customer Suspended!', {
            body: "Please Check Your list, New Customer Suspended.",
          });
          
        });

        // update the list
        $.ajax({
           url: "/CRM/suspend/noc/customer",
           method:'get',
           success:function(response)
           {
            $('#noc_table_suspend').empty().html(response);
           }
        });   

    });

    // Publish notification when customer has been terminated
    Echo.channel('terminate')
        .listen('terminateEvent',function(){

        // Publish Notifications        
        if (! ('Notification' in window)) {
          alert('Web Notification is not supported');
          return;
        }

        Notification.requestPermission( permission => {
          let notification = new Notification('Customer Terminated!', {
            body: "Please Check Your list, New Customer Terminated.",
          });
          
        });

        // update the list
        $.ajax({
           url: "/CRM/terminate/noc/customer",
           method:'get',
           success:function(response)
           {
            $('#noc_table_terminate').empty().html(response);
           }
        }); 

    });

    // Publish notification for new amedments
    Echo.channel('amendment')
        .listen('amendmentEvent',function(){
        
          // Publish Notifications        
        if (! ('Notification' in window)) {
          alert('Web Notification is not supported');
          return;
        }

        Notification.requestPermission( permission => {
          let notification = new Notification('Customer Amedment!', {
            body: "Please Check Your list, New Customer Amedment.",
          });
          
        });

        // update the list
        $.ajax({
           url: "/CRM/amed/noc/customer",
           method:'get',
           success:function(response)
           {
            $('#noc_table_amed').empty().html(response);
           }
        });

    });  

     /***********************************************************/ 
    /*****************Provincial Customers**********************/ 
    /***********************************************************/ 

    //Publish notification for new amedments
    Echo.channel('prProcess')
        .listen('prProcessEvent',function(){
        
          // Publish Notifications        
        if (! ('Notification' in window)) {
          alert('Web Notification is not supported');
          return;
        }

        Notification.requestPermission( permission => {
          let notification = new Notification('New Customer Process!', {
            body: "Please Check Your list, New Customer for process.",
          });
          
        });

        // update the list
        $.ajax({
           url: "/CRM/pr/noc/process",
           method:'get',
           success:function(response)
           {
            $('#pr_noc_requests').empty().html(response);
           }
        });

    });

    // Publish notification for new terminates
    Echo.channel('prTerminate')
        .listen('prTerminateEvent',function(){
        
          // Publish Notifications        
        if (! ('Notification' in window)) {
          alert('Web Notification is not supported');
          return;
        }

        Notification.requestPermission( permission => {
          let notification = new Notification('New Termination!', {
            body: "Please Check Your list, New Customer Termination.",
          });
          
        });

        // update the list
        $.ajax({
           url: "/CRM/pr/noc/terminate",
           method:'get',
           success:function(response)
           {
            $('#pr_noc_terminate').empty().html(response);
           }
        });

    });

    // Publish notification for new suspend
    Echo.channel('prSalesSuspend')
        .listen('prSalesSuspend',function(){
        
          // Publish Notifications        
        if (! ('Notification' in window)) {
          alert('Web Notification is not supported');
          return;
        }

        Notification.requestPermission( permission => {
          let notification = new Notification('New Suspend!', {
            body: "Please Check Your list, New Customer Suspend.",
          });
          
        });

        // update the list
        $.ajax({
           url: "/CRM/pr/noc/suspendEvent",
           method:'get',
           success:function(response)
           {
            $('#pr_noc_suspends').empty().html(response);
           }
        });

    }); 

    // Publish notification for new suspend
    Echo.channel('prFinanceSuspend')
        .listen('prFinanceSuspend',function(){
        
        // Publish Notifications        
        if (! ('Notification' in window)) {
          alert('Web Notification is not supported');
          return;
        }

        Notification.requestPermission( permission => {
          let notification = new Notification('New Suspend!', {
            body: "Please Check Your list, New Customer Suspend.",
          });
          
        });

        // update the list
        $.ajax({
           url: "/CRM/pr/noc/suspendEvent",
           method:'get',
           success:function(response)
           {
            $('#pr_noc_suspends').empty().html(response);
           }
        });

    }); 

    // Publish notification for new amendment
    Echo.channel('prAmendmentEvent')
        .listen('prAmendmentEvent',function(){
        
          // Publish Notifications        
        if (! ('Notification' in window)) {
          alert('Web Notification is not supported');
          return;
        }

        Notification.requestPermission( permission => {
          let notification = new Notification('New Suspend!', {
            body: "Please Check Your list, New Customer Suspend.",
          });
          
        });

        // update the list
        $.ajax({
           url: "/CRM/pr/noc/amendmentEvent",
           method:'get',
           success:function(response)
           {
            $('#pr_noc_amends').empty().html(response);
           }
        });

    });

    // Publish notification for Cancels
    Echo.channel('prSalesCancel')
        .listen('prSalesCancel',function(){
        
          // Publish Notifications        
        if (! ('Notification' in window)) {
          alert('Web Notification is not supported');
          return;
        }

        Notification.requestPermission( permission => {
          let notification = new Notification('New Cancels!', {
            body: "Please Check Your list, New Customer Canceled.",
          });
          
        });

        // update the list
        $.ajax({
           url: "/CRM/pr/noc/cancelEvent",
           method:'get',
           success:function(response)
           {
            $('#pr_noc_cancels').empty().html(response);
           }
        });

    });      

});