// services/entretien.service.js
import api from '@/axios/axios';

export const getCommunauteNumber = () => {

   return api.get('communaute/count');
}

export const  getCommunaute = (year) => {
    if (year && year !== '' && year !== 'null') {
        return api.get('/communautes?year=' + year);
    } else {
        return api.get('/communautes');
    }
}

export const createCommunaute = (communaute) => {
    return api.post('/communaute', communaute);
}

export const deleteCommunaute = (id) => {
    return api.delete('/communauteDelete/' + id);
}
export const getCommunauteById = (id) => {
    return api.get('/communaute/' + id);
}

export const updateCommunaute = (id,communaute) => {
    return api.put('/communauteUpdate/' + id, communaute);
}

