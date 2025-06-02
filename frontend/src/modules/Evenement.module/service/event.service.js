import api from '@/axios/axios';

export const getEventCount = (years) => {
    if (years && years !== '' && years !== 'null') {
        return api.get('/EventCount?year=' + years);
    } else {
        return api.get('/EventCount');
    }    
};

export const getEventsYears = () => {
    return api.get('/EventYears');
}

export const getEvents = ( ) => {
  
    return api.get('/EventList');
  }


export const getEventById = (id) => {
    return api.get('/Event/' + id);
}


export const deleteEvent = (id) => {
    return api.delete('/EventDelet/' + id);
}


export const ajouterEvent = (event) => {    
    return api.post('/EventCreat', event);
}
