// services/entretien.service.js
import api from '@/axios/axios';

export const getInterviewCountByPromotion = (promotion) => {
  return api.get(`/entretiens/count/${promotion}`);
};
