// services/entretien.service.js
import api from '@/axios/axios';

export const getCommauteNumber = () => {
  return api.get(`/communaute`);
};
