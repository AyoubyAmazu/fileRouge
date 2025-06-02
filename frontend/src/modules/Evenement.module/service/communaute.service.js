// services/entretien.service.js
import api from '@/axios/axios';

export const getCommunauteNumber = () => {
    
   return api.get('communaute/count');
};
