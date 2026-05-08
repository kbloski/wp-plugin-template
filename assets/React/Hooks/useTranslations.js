const {useCallback} = wp.element;

export const useTranslations = () => {
  const translations = window.__plugintemplate_TRANSLATIONS?.data ?? {};

  const t = useCallback((key) => {
    return translations?.[key] ?? key;
  }, [translations]);

  return t;
};