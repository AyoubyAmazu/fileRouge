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


