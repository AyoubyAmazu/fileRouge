// services/groupe.service.js
import api from '@/axios/axios';

export const getPromotions = () => {
  return api.get('/groupe');
};
  
