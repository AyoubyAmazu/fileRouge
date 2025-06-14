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

export const getEvents = ($year) => {

    return api.get('/EventList?year=' + $year);
  }


export const getEventById = (id) => {
    return api.get('/Event/' + id);
}


export const deleteEvent = (id) => {
    return api.delete('/EventDelete/' + id);
}


export const ajouterEvent = (event) => {
    return api.post('/EventCreat', event);
}


export const updateEvent = (eventId,event) => {
    return api.put('/EventUpdate/'+eventId , event);
}
