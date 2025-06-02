import api from '@/axios/axios';

export const getSTodayStudentCheckinCount = () => {
  return api.get('/student-checkins/today');
};

export const getAvgCheckinsPerPeriod = () => {
  return api.get('/student-checkins/period-avg');
};

// Fixed: Use URL parameter instead of query parameter
export const getStudentCheckinPeriods = (promotionId) => {
  console.log('Fetching periods for promotion:', promotionId);
  return api.get(`/student-checkins/period/${promotionId}`);
};

// Fixed: Use URL parameter instead of query parameter
export const getRecentStudentCheckins = (promotionId) => {
  console.log('Fetching recent checkins for promotion:', promotionId);
  return api.get(`/student-checkins/recent/${promotionId}`);
};