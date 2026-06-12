const {useCallback} = wp.element;

export const useTranslations = () => {
  const translations = window.__plugintemplate.translations?.data ?? {};

  const t = useCallback((key) => {
    return translations?.[key] ?? key;
  }, [translations]);

  return t;
};