"use strict";

const autosave = {
    loaded_data: {},
    state: {},
    data: [],
    error_counter: 0,
    
    save_scheduled: false,
    
    save_state: function(state) {
        for (const prop in state) {
            this.state[prop] = state[prop];
        }
        
        this.schedule_autosave();
    },
    
    save: function(data) {
        this.data.push(data);
        this.schedule_autosave();
    },
    
    schedule_autosave: function(delay = 0) {
        if (this.save_scheduled) return;
        
        this.save_scheduled = true;
        
        // add to queue, so that multiple saves can be done simultaneously
        window.setTimeout(() => this.execute_save(), delay);
    },
    
    execute_save: async function() {
        const data = this.get_new_data();
        fetch(this.get_save_url(), this.get_fetch_options(data))
            .then(resp => resp.text())
            .then(text => this.check_ajax_response(text, data))
            .catch(err => this.handle_ajax_error(err));
    },
    
    get_new_data: function() {
        return {state: this.state, data: this.data};
    },
    
    get_save_url: function() {
        return this.get_exp_name() + "/save/";
    },
    
    get_exp_name: function() {
        let path_parts = window.location.pathname.split("/");
        // expecting something like [..., ${exp_name}, "experiment", ""]
        // from pathname like ".../${exp_name}/experiment/"
        return path_parts[path_parts.length - 3];
    },
    
    get_fetch_options: function(data) {
        return {
            method: "POST",
            headers: {"Content-type": "application/json"},
            body: JSON.stringify(data),
        };
    },
    
    check_ajax_response: function(response_text, data) {
        if (response_text !== "success") throw response_text;
        
        this.clean_up_after_save(data);
    },
    
    clean_up_after_save: function(data) {
        this.save_scheduled = false;
        this.error_counter = 0;
        this.clear_saved_data(data);
        
        if (COLLECTOR.admin) console.log("autosave completed successfully");
        
        if (this.has_new_data()) {
            this.schedule_autosave();
        }
    },
    
    clear_saved_data: function(data) {
        for (const prop in data.state) {
            if (this.state[prop] === data.state[prop]) {
                delete this.state[prop];
            }
        }
        
        this.data.splice(0, data.data.length);
    },
    
    has_new_data: function() {
        return Object.keys(this.state) > 0 || this.data.length > 0;
    },
    
    handle_ajax_error: function(err_msg) {
        const wait_time = Math.min(120, 2 ** this.error_counter++);
        this.save_scheduled = false;
        //this.schedule_autosave(1000 * wait_time);
        
        console.error(err_msg);
        console.error(`waiting ${wait_time} before resubmitting`);
    }
};
